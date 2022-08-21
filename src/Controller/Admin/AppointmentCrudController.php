<?php

namespace App\Controller\Admin;

use App\Entity\Appointment;
use App\Entity\User;
use App\Service\BusinessService;
use App\Service\Traits\BusinessServiceTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use App\Controller\Admin\Interfaces\AppointmentCrudControllerInterface;

class AppointmentCrudController extends AbstractCrudController implements AppointmentCrudControllerInterface
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
            ->setEntityLabelInSingular('Cita')
            ->setEntityLabelInPlural('Citas')
            ->setSearchFields(array('bookingDate', 'status'))
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
            DateTimeField::new('bookingDateAt', 'Fecha de reserva')->setDisabled(TRUE),
            ChoiceField::new('status', 'Estado')
                ->setChoices(Appointment::getStatusChoices()),
            TextField::new('worker.name', 'Nombre Trabajador')
                ->setHelp('*  Nombre del trabajador del negocio encargado de atender la cita')
                ->setDisabled(TRUE),
            TextField::new('worker.surname', 'Apellido Trabajador')
                ->setHelp('*  Apellido del trabajador del negocio encargado de atender la cita')
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
            ->add(DateTimeFilter::new('bookingDateAt', 'Fecha de reserva'),)
            ->add(ChoiceFilter::new(
                'status', 'Estado')->setChoices(Appointment::getStatusChoices())
            );
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

        if (!in_array(User::ROLE_ADMIN, $this->getUser()->getRoles())):
            $actions
                ->disable('delete');
        endif;

        return $actions
            ->disable('detail');
    }

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public static function getEntityFqcn(): string
    {
        return Appointment::class;
    }

}
