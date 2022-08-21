<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Category;
use App\Service\BusinessService;
use App\Service\Traits\BusinessServiceTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use App\Controller\Admin\Interfaces\CategoryCrudControllerInterface;

class CategoryCrudController extends AbstractCrudController implements CategoryCrudControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    use BusinessServiceTrait;

    /************************************************* CONSTRUCT **************************************************/

    /**
     * CategoryCrudController construct
     *
     * @param EntityRepository $entityRepository EntityRepository to override the query builds.
     */
    public function __construct(EntityRepository $entityRepository, BusinessService  $businessService)
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
            ->setEntityLabelInSingular('Categoría')
            ->setEntityLabelInPlural('Categorías')
            ->setSearchFields(array('name', 'description'))
            ->setPageTitle(Crud::PAGE_NEW, 'Nueva Categoría')
            ->setHelp(
                Crud::PAGE_NEW,
                'En esta vista podrás crear una nueva categoría para los productos de tu negocio con 
                los datos que sean especificados.'
            )
            ->setPageTitle(Crud::PAGE_EDIT, 'Editar Categoría')
            ->setHelp(
                Crud::PAGE_EDIT,
                'En esta vista podrás editar la categoría seleccionada.'
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
            TextField::new('name', 'Categoría')
                ->setHelp('*  Nombre de la categoría'),
            TextField::new('description', 'Descripción')
                ->setHelp('*  Descripción de la categoría'),
            AssociationField::new('business', 'Negocio')
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
            ->add(TextFilter::new('name', 'Categoría'))
            ->add(TextFilter::new('description', 'Descripción'));
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
                return $action->setLabel('Nueva Categoría');
            });
    }

    /**
     * @param string $entityFqcn
     * @return Category Category
     */
    public function createEntity(string $entityFqcn): Category
    {
        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        $business = $this->getUser()->getBusiness();
        if ($business === NULL):
            $allBusiness = $this->getBusinessService()->getBusinessRepository()->findAll();
            $business = $allBusiness[0];
        endif;

        return new Category($business, '', '');
    }

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

}
