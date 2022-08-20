<?php

namespace App\Controller\Admin;

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
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use App\Controller\Admin\Interfaces\ImageCrudControllerInterface;

class ImageCrudController extends AbstractCrudController implements ImageCrudControllerInterface
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
            ->setEntityLabelInSingular('Imagen Red Social')
            ->setEntityLabelInPlural('Imágenes Red Social')
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
        /** @noinspection PhpUndefinedMethodInspection */
        return array(
            FormField::addPanel('Información General'),
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Imagen')->hideOnForm(),
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

        if (empty($this->getBusinessService()->getBusinessRepository()->findAll())):
            $actions
                ->disable('new');
        endif;

        return $actions
            ->disable('detail')
            # PAGE_INDEX
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Nueva Imagen');
            });
    }

    /**
     * @param string $entityFqcn
     * @return Image Image
     */
    public function createEntity(string $entityFqcn): Image
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $business = $this->getUser()->getBusiness();
        if ($business === NULL):
            $allBusiness = $this->getBusinessService()->getBusinessRepository()->findAll();
            $business = $allBusiness[0];
        endif;

        $homeConfig = $this->getBusinessService()->getHomeConfigRepository()->findByBusiness($business);

        return new Image($homeConfig, '', 300, 300, '');
    }

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

}
