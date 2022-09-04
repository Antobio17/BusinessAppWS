<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\Types\PostalAddressType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use App\Controller\Admin\Interfaces\UserCrudControllerInterface;

class UserCrudController extends AbstractCrudController implements UserCrudControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

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
            ->setEntityLabelInSingular('Usuario')
            ->setEntityLabelInPlural('Usuarios')
            ->setSearchFields(array('email'));
    }

    /**
     * @param Filters $filters
     *
     * @return Filters Filters
     */
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters);
    }

    /**
     * @inheritDoc
     * @return Crud Crud
     */
    public function configureFields(string $pageName): iterable
    {
        $disable = !in_array(User::ROLE_ADMIN, $this->getUser()->getRoles());
        return array(
            FormField::addPanel('Información General'),
            IdField::new('id')->hideOnForm(),
            AssociationField::new('business', 'Negocio')->setDisabled($disable),
            TextField::new('email', 'Email'),
            TextField::new('phoneNumber', 'Teléfono'),
            TextField::new('name', 'Nombre'),
            TextField::new('surname', 'Apellidos'),
            BooleanField::new('isWorker', 'Trabajador')
                ->setDisabled($pageName !== Crud::PAGE_NEW),
            BooleanField::new('isVerified', 'Verificado'),
            FormField::addPanel('Dirección Postal')->hideWhenCreating(),
            CollectionField::new('postalAddresses')
                ->hideOnIndex()
                ->hideWhenCreating()
                ->allowAdd(FALSE)
                ->allowDelete(FALSE)
                ->setLabel(FALSE)
                ->setEntryType(PostalAddressType::class)
                ->setFormTypeOptions(array(
                    'by_reference' => FALSE,
                )),
        );
    }

    /**
     * @inheritDoc
     * @return Actions Actions
     */
    public function configureActions(Actions $actions): Actions
    {
        parent::configureActions($actions);

        return $actions
            ->disable('delete')
            # PAGE_INDEX
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Nuevo Usuario');
            });
    }

    /**
     * @return User User
     */
    public function createEntity(string $entityFqcn): User
    {
        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        return new User(
            $this->getUser()->getBusiness(), '', '', '', '', ''
        );
    }

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

}
