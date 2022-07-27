<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

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
}
