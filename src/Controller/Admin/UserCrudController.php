<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use App\Controller\Admin\Interfaces\UserCrudControllerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController implements UserCrudControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    /************************************************** ROUTING ***************************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return Crud Crud
     */
    public function configureFields(string $pageName): iterable
    {
        return array(
            IdField::new('id'),
            AssociationField::new('business', 'Negocio'),
            TextField::new('email', 'Email'),
            TextField::new('phoneNumber', 'Teléfono'),
            TextField::new('name', 'Nombre'),
            TextField::new('surname', 'Apellidos'),
            BooleanField::new('isWorker', 'Trabajador')->setDisabled(TRUE),
        );
    }

    /*********************************************** STATIC METHODS ***********************************************/

}
