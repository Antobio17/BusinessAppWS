<?php

namespace App\Controller\Admin;

use App\Entity\Business;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use App\Controller\Admin\Interfaces\BusinessCrudControllerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BusinessCrudController extends AbstractCrudController implements BusinessCrudControllerInterface
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
        return Business::class;
    }

    /************************************************** ROUTING ***************************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return Crud Crud
     */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Negocio')
            ->setEntityLabelInPlural('Negocios')
            ->setDateFormat('H:i:s d-m-Y');
    }

    /**
     * @inheritDoc
     * @return iterable iterable
     */
    public function configureFields(string $pageName): iterable
    {
        return array(
            IdField::new('id'),
            TextField::new('domain', 'Dominio'),
            TextField::new('name', 'Nombre'),
            TextField::new('phoneNumber', 'Teléfono'),
            TextField::new('email'),
        );
    }

    /*********************************************** STATIC METHODS ***********************************************/

}
