<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\SocialImage;
use App\Service\BusinessService;
use App\Service\Traits\BusinessServiceTrait;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use App\Controller\Admin\Interfaces\SocialImageCrudControllerInterface;

class SocialImageCrudController extends AbstractCrudController implements SocialImageCrudControllerInterface
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
     * @return Crud Crud
     */
    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInSingular('Imagen de Red Social')
            ->setEntityLabelInPlural('Imágenes de Red Social')
            ->setSearchFields(array('name', 'alt'))
            ->setPageTitle(Crud::PAGE_NEW, 'Nueva Imagen')
            ->setHelp(
                Crud::PAGE_NEW,
                'En esta vista podrás crear una nueva imagen para la sección de Red Social de tu negocio.'
            )
            ->setPageTitle(Crud::PAGE_EDIT, 'Editar Imagen')
            ->setHelp(
                Crud::PAGE_EDIT,
                'En esta vista podrás editar la imagen seleccionada.'
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
            ImageField::new('name', 'Imagen')->setBasePath('/images')->hideOnForm(),
            ImageField::new('name', 'Imagen')
                ->setUploadDir('public/images/')
                ->onlyOnForms()
                ->setUploadedFileNamePattern(
                    fn (UploadedFile $file): string => sprintf(
                        '%d-%s',
                        date_create()->getTimestamp(),
                        $file->getClientOriginalName()
                    )
                ),
            IntegerField::new('width', 'Anchura (px)')
                ->setDisabled(TRUE)
                ->setHelp('*  Anchura de la imagen en píxeles'),
            IntegerField::new('height', 'Altura  (px)')
                ->setDisabled(TRUE)
                ->setHelp('*  Altura de la imagen en píxeles'),
            TextField::new('alt', 'Alt')
                ->setRequired(TRUE)
                ->setHelp('*  Propiedad HTML alt de la imagen'),
            AssociationField::new('homeConfig', 'Configuración de Home')
                ->setDisabled(
                    !in_array(User::ROLE_ADMIN, $this->getUser()->getRoles())
                    || $pageName === Crud::PAGE_EDIT
                ),
        );
    }

    /**
     * @inheritDoc
     * @return Filters Filters
     */
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add(TextFilter::new('name', 'Imagen'))
            ->add(TextFilter::new('alt', 'Alt'));
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
            # PAGE_INDEX
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Nueva Imagen');
            });
    }

    /**
     * @param string $entityFqcn
     * @return SocialImage SocialImage
     */
    public function createEntity(string $entityFqcn): SocialImage
    {
        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        $business = $this->getUser()->getBusiness();
        if ($business === NULL):
            $allBusiness = $this->getBusinessService()->getBusinessRepository()->findAll();
            $business = $allBusiness[0];
        endif;

        $homeConfig = $this->getBusinessService()->getHomeConfigRepository()->findByBusiness($business);

        return new SocialImage($homeConfig, '', 300, 300, '');
    }

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public static function getEntityFqcn(): string
    {
        return SocialImage::class;
    }

}
