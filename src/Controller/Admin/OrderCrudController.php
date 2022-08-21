<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Entity\User;
use App\Service\BusinessService;
use App\Service\Traits\BusinessServiceTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use App\Controller\Admin\Interfaces\OrderCrudControllerInterface;

class OrderCrudController extends AbstractCrudController implements OrderCrudControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    use BusinessServiceTrait;

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
            ->setEntityLabelInSingular('Pedido')
            ->setEntityLabelInPlural('Pedidos')
            ->setSearchFields(array('uuid', 'amount', 'status', 'createdAt', 'sendAt'))
            ->setPageTitle(Crud::PAGE_EDIT, 'Editar Pedido')
            ->setHelp(
                Crud::PAGE_EDIT,
                'En esta vista podrás editar el estado del pedido seleccionada.'
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
            TextField::new('uuid', 'UUID')->setDisabled(TRUE),
            NumberField::new('amount', 'Total (€)')->setDisabled(TRUE),
            ChoiceField::new('status', 'Estado')
                ->setChoices(Order::getStatusChoices()),
            DateTimeField::new('createdAt', 'Fecha de creación')->setDisabled(TRUE),
            DateTimeField::new('sentAt', 'Fecha de envío')->setDisabled(TRUE),
            AssociationField::new('user', 'Cliente')
                ->setDisabled(TRUE),
            AssociationField::new('business', 'Negocio')
                ->setDisabled(TRUE),
        );
    }

    /**
     * @inheritDoc
     * @return Filters Filters
     */
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add(TextFilter::new('uuid', 'UUID'))
            ->add(ChoiceFilter::new(
                'status', 'Estado')->setChoices(Order::getStatusChoices())
            )
            ->add(DateTimeFilter::new('createdAt', 'Fecha de creación'))
            ->add(DateTimeFilter::new('sentAt', 'Fecha de envío'));
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

        return $actions
            ->disable('new', 'detail');
    }

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

}
