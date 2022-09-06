<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Entity\User;
use App\Service\BusinessService;
use App\Service\Traits\BusinessServiceTrait;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use App\Entity\BusinessService as BusinessServiceEntity;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use App\Controller\Admin\Interfaces\BusinessServiceCrudControllerInterface;

class BusinessServiceCrudController extends AbstractCrudController implements BusinessServiceCrudControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    use BusinessServiceTrait;

    /************************************************* CONSTRUCT **************************************************/

    /**
     * SocialImageCrudController construct
     *
     * @param EntityRepository $entityRepository EntityRepository to override the query builds.
     */
    public function __construct(EntityRepository $entityRepository, BusinessService $businessService)
    {
        parent::__construct($entityRepository);

        $this->setBusinessService($businessService);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /************************************************** ROUTING ***************************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return QueryBuilder QueryBuilder
     */
    public function createIndexQueryBuilder(SearchDto        $searchDto, EntityDto $entityDto, FieldCollection $fields,
                                            FilterCollection $filters): QueryBuilder
    {
        /** @noinspection DuplicatedCode */
        if ($this->getUser() instanceof User && !in_array(User::ROLE_ADMIN, $this->getUser()->getRoles())):
            /** @noinspection PhpPossiblePolymorphicInvocationInspection */
            $business = $this->getUser()->getBusiness();
            $homeConfig = $this->getBusinessService()->getHomeConfigRepository()->findByBusiness($business);
        endif;

        $queryBuilder = $this->getEntityRepository()->createQueryBuilder($searchDto, $entityDto, $fields, $filters);

        if (isset($homeConfig)):
            $homeConfigID = $homeConfig->getID();
        elseif (!in_array(User::ROLE_ADMIN, $this->getUser()->getRoles())):
            $homeConfigID = -1;
        endif;

        if (isset($homeConfigID)):
            $queryBuilder->andWhere('entity.homeConfig = :homeConfig');
            $queryBuilder->setParameter('homeConfig', $homeConfigID);
        endif;

        return $queryBuilder;
    }

    /**
     * @inheritDoc
     * @return Crud Crud
     */
    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInSingular('Servicio de Negocio')
            ->setEntityLabelInPlural('Servicios de Negocio')
            ->setSearchFields(array('name', 'description'))
            ->setPageTitle(Crud::PAGE_NEW, 'Nuevo Servicio')
            ->setHelp(
                Crud::PAGE_NEW,
                'En esta vista podrás crear un nuevo servicio para la sección de Servicios ofrecidos 
                de tu negocio.'
            )
            ->setPageTitle(Crud::PAGE_EDIT, 'Editar Servicio')
            ->setHelp(
                Crud::PAGE_EDIT,
                'En esta vista podrás editar el servicio seleccionada.'
            );
    }

    /**
     * @inheritDoc
     * @return iterable iterable
     */
    public function configureFields(string $pageName): iterable
    {
        return array(
            FormField::addPanel('Información General'),
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Título'),
            TextareaField::new('description', 'Descripción'),
            AssociationField::new('homeConfig', 'Configuración de Home')
                ->setDisabled(
                    !in_array(User::ROLE_ADMIN, $this->getUser()->getRoles())
                    || $pageName === Crud::PAGE_EDIT
                ),
            FormField::addPanel('Icono del servicio'),
            ImageField::new('image.name', 'Imagen')->setBasePath('/images')->onlyOnIndex(),
            ImageField::new('image.name', 'Imagen')
                ->setUploadDir('public/images/')
                ->setRequired($pageName === Crud::PAGE_NEW)
                ->onlyOnForms()
                ->setUploadedFileNamePattern(
                    fn(UploadedFile $file): string => sprintf(
                        '%d-%s',
                        date_create()->getTimestamp(),
                        $file->getClientOriginalName()
                    )
                ),
            IntegerField::new('image.width', 'Anchura (px)')
                ->setDisabled(TRUE)
                ->onlyOnForms()
                ->setHelp('*  Anchura de la imagen en píxeles'),
            IntegerField::new('image.height', 'Altura  (px)')
                ->setDisabled(TRUE)
                ->onlyOnForms()
                ->setHelp('*  Altura de la imagen en píxeles'),
            TextField::new('image.alt', 'Alt')
                ->setRequired(TRUE)
                ->setHelp('*  Propiedad HTML alt de la imagen'),
        );
    }

    /**
     * @inheritDoc
     * @return Filters Filters
     */
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add(TextFilter::new('name', 'Título'))
            ->add(TextFilter::new('description', 'Descripción'));
    }

    /**
     * @inheritDoc
     * @return Actions Actions
     */
    public function configureActions(Actions $actions): Actions
    {
        parent::configureActions($actions);

        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        $business = $this->getUser()->getBusiness();
        if (empty($this->getBusinessService()->getBusinessRepository()->findAll()) || ($business !== NULL
                && empty($this->getBusinessService()->getHomeConfigRepository()->findByBusiness($business)))):
            $actions
                ->disable('new');
        endif;

        return $actions
            ->disable('detail')
            # PAGE_INDEX
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Nuevo Servicio');
            });
    }

    /**
     * @param string $entityFqcn
     * @return BusinessServiceEntity BusinessServiceEntity
     */
    public function createEntity(string $entityFqcn): BusinessServiceEntity
    {
        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        $business = $this->getUser()->getBusiness();
        if ($business === NULL):
            $allBusiness = $this->getBusinessService()->getBusinessRepository()->findAll();
            $business = $allBusiness[0];
        endif;

        $homeConfig = $this->getBusinessService()->getHomeConfigRepository()->findByBusiness($business);

        return new BusinessServiceEntity(
            $homeConfig, new Image('', 60, 60, ''), '', ''
        );
    }

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public static function getEntityFqcn(): string
    {
        return BusinessServiceEntity::class;
    }

}
