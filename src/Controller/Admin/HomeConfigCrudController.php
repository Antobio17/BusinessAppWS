<?php

namespace App\Controller\Admin;

use App\Entity\HomeConfig;
use App\Entity\User;
use App\Entity\Image;
use App\Service\BusinessService;
use App\Service\Traits\BusinessServiceTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use App\Controller\Admin\Interfaces\HomeConfigCrudControllerInterface;

class HomeConfigCrudController extends AbstractCrudController implements HomeConfigCrudControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    use BusinessServiceTrait;

    /************************************************* CONSTRUCT **************************************************/

    /**
     * ImageCrudController construct
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
            ->setEntityLabelInSingular('Configuración Home')
            ->setEntityLabelInPlural('Configuraciones Home')
            ->setSearchFields(array('name', 'description'))
            ->setPageTitle(Crud::PAGE_NEW, 'Nueva Configuración')
            ->setHelp(
                Crud::PAGE_NEW,
                'En esta vista podrás crear una nueva configuración de Home de tu negocio.'
            )
            ->setPageTitle(Crud::PAGE_EDIT, 'Editar Configuración')
            ->setHelp(
                Crud::PAGE_EDIT,
                'En esta vista podrás editar la configuración seleccionada.'
            );
    }

    /**
     * @inheritDoc
     * @return iterable iterable
     */
    public function configureFields(string $pageName): iterable
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return array(
            FormField::addPanel('Sección de Introducción'),
            IdField::new('id')->hideOnForm(),
            TextField::new('image.name', 'Imagen')->onlyOnIndex(),
            ImageField::new('image.name', 'Imagen')
                ->setUploadDir('public/images/')
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
                ->setValue(300)
                ->onlyOnForms()
                ->setHelp('*  Anchura de la imagen en píxeles'),
            IntegerField::new('image.height', 'Altura  (px)')
                ->setDisabled(TRUE)
                ->setValue(300)
                ->onlyOnForms()
                ->setHelp('*  Altura de la imagen en píxeles'),
            TextField::new('image.alt', 'Alt')
                ->setHelp('*  Propiedad HTML alt de la imagen')
                ->setRequired(TRUE),
            TextField::new('name', 'Nombre')
                ->setHelp('*  Nombre completo del CEO del negocio.'),
            TextareaField::new('description', 'Descripción')
                ->setHelp('*  Descripción del CEO del negocio para la introducción.'),
        );
    }

    /**
     * @inheritDoc
     * @return Filters Filters
     */
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add(TextFilter::new('name', 'Nombre completo del CEO'))
            ->add(TextFilter::new('description', 'Descripción'));
    }

    /**
     * @inheritDoc
     * @return Actions Actions
     */
    public function configureActions(Actions $actions): Actions
    {
        parent::configureActions($actions);

        /** @noinspection PhpUndefinedMethodInspection */
        $business = $this->getUser()->getBusiness();
        if (
            empty($this->getBusinessService()->getBusinessRepository()->findAll()) || ($business !== NULL
                && !empty($this->getBusinessService()->getHomeConfigRepository()->findByBusiness($business)))
        ):
            $actions
                ->disable('new');
        endif;

        return $actions
            ->disable('detail', 'delete')
            # PAGE_INDEX
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Nueva Configuración');
            });
    }

    /**
     * @param string $entityFqcn
     *
     * @return HomeConfig HomeConfig
     */
    public function createEntity(string $entityFqcn): HomeConfig
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $business = $this->getUser()->getBusiness();
        if ($business === NULL):
            $allBusiness = $this->getBusinessService()->getBusinessRepository()->findAll();
            $business = $allBusiness[0];
        endif;

        return new HomeConfig($business, new Image('', 300, 300, ''), '', '');
    }

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public static function getEntityFqcn(): string
    {
        return HomeConfig::class;
    }

}
