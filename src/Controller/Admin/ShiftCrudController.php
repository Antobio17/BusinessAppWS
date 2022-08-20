<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Shift;
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
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Controller\Admin\Interfaces\ShiftCrudControllerInterface;

class ShiftCrudController extends AbstractCrudController implements ShiftCrudControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    use BusinessServiceTrait;

    /************************************************* CONSTRUCT **************************************************/

    /**
     * AbstractCrudController construct
     *
     * @param EntityRepository $entityRepository EntityRepository to override the query builds.
     */
    public function __construct(EntityRepository $entityRepository, AdminUrlGenerator $adminURLGenerator,
                                BusinessService  $businessService)
    {
        parent::__construct($entityRepository, $adminURLGenerator);

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
            ->setEntityLabelInSingular('Turno')
            ->setEntityLabelInPlural('Turnos')
            ->setSearchFields(array('opensAt', 'closesAt'))
            ->setPageTitle(Crud::PAGE_NEW, 'Nuevo Turno')
            ->setHelp(
                Crud::PAGE_NEW,
                'En esta vista podrás crear un nuevo turno para tu negocio con los datos que sean 
                especificados.'
            )
            ->setPageTitle(Crud::PAGE_EDIT, 'Editar Turno')
            ->setHelp(
                Crud::PAGE_EDIT,
                'En esta vista podrás editar el turno seleccionada.'
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
            ChoiceField::new('weekDay', 'Día de la semana')
                ->setChoices(Shift::getDaysChoices()),
            TextField::new('opensAt', 'Hora de apertura')
                ->setHelp('*  Hora de apertura del turno (Formato: 09:00:00'),
            TextField::new('closesAt', 'Hora de cierre')
                ->setHelp('*  Hora de cierre del turno (Formato: 14:00:00'),
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
            ->add(ChoiceFilter::new(
                'weekDay', 'Día de la semana')->setChoices(Shift::getDaysChoices())
            )
            ->add(TextFilter::new('opensAt', 'Apertura'))
            ->add(TextFilter::new('closesAt', 'Cierre'));
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
                return $action->setLabel('Nuevo Turno');
            });
    }

    /**
     * @param string $entityFqcn
     * @return Shift Shift
     */
    public function createEntity(string $entityFqcn): Shift
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $business = $this->getUser()->getBusiness();
        if ($business === NULL):
            $allBusiness = $this->getBusinessService()->getBusinessRepository()->findAll();
            $business = $allBusiness[0];
        endif;

        return new Shift($business, '', '', 0);
    }

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public static function getEntityFqcn(): string
    {
        return Shift::class;
    }

}
