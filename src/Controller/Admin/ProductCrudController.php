<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Image;
use App\Entity\Product;
use App\Entity\Category;
use App\Service\BusinessService;
use App\Service\Traits\BusinessServiceTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use App\Controller\Admin\Interfaces\ProductCrudControllerInterface;

class ProductCrudController extends AbstractCrudController implements ProductCrudControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    use BusinessServiceTrait;

    /**
     * @var array array
     */
    protected array $categoryChoices = array();

    /************************************************* CONSTRUCT **************************************************/

    /**
     * ShiftCrudController construct
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
            ->setEntityLabelInSingular('Producto')
            ->setEntityLabelInPlural('Productos')
            ->setSearchFields(array('name', 'code', 'description', 'amount', 'category'))
            ->setPageTitle(Crud::PAGE_EDIT, 'Editar Cita')
            ->setHelp(
                Crud::PAGE_EDIT,
                'En esta vista podrás editar el estado de la cita seleccionada.'
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
            TextField::new('name', 'Nombre'),
            TextField::new('code', 'Código'),
            TextareaField::new('description', 'Descripción')->hideOnIndex(),
            NumberField::new('amount', 'Total (€)'),
            IntegerField::new('stock', 'Stock'),
            IntegerField::new('discountPercent', 'Descuento (%)'),
            AssociationField::new('category', 'Categoría'),
            FormField::addPanel('Imagen del producto'),
            ImageField::new('image.name', FALSE)->setBasePath('/images')->hideOnForm(),
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
                ->onlyOnForms()
                ->setHelp('*  Anchura de la imagen en píxeles'),
            IntegerField::new('image.height', 'Altura  (px)')
                ->setDisabled(TRUE)
                ->onlyOnForms()
                ->setHelp('*  Altura de la imagen en píxeles'),
            TextField::new('image.alt', 'Alt')
                ->onlyOnForms()
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
            ->add(TextFilter::new('name', 'Nombre'))
            ->add(TextFilter::new('code', 'Código'))
            ->add(NumericFilter::new('amount', 'Total (€)'))
            ->add(NumericFilter::new('stock', 'Stock'))
            ->add(NumericFilter::new('discountPercent', 'Descuento (%)'));
    }

    /**
     * @inheritDoc
     * @return Actions Actions
     */
    public function configureActions(Actions $actions): Actions
    {
        parent::configureActions($actions);

        if (!in_array(User::ROLE_ADMIN, $this->getUser()->getRoles())):
            $actions
                ->disable('delete');
        endif;

        $categories = $this->getBusinessService()->getCategoryRepository()->findAll();
        if (empty($categories)):
            $actions
                ->disable('new');
        endif;

        return $actions;
    }

    /**
     * @param string $entityFqcn
     * @return Product Product
     */
    public function createEntity(string $entityFqcn): Product
    {
        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        $business = $this->getUser()->getBusiness();
        if ($business === NULL):
            $allBusiness = $this->getBusinessService()->getBusinessRepository()->findAll();
            $business = $allBusiness[0];
        endif;

        $categories = $this->getBusinessService()->getCategoryRepository()->findAll();
        if (!empty($categories)):
            $category = $categories[0];
        endif;

        return new Product(
            $business, '', '', '', 0.0,
            $category ?? new Category('', ''),
            new Image('', 230, 200, '')
        );
    }

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

}
