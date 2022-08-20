<?php

namespace App\Controller\Admin\Interfaces;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

interface UserCrudControllerInterface
{

    /************************************************** ROUTING ***************************************************/

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Method to configure the CRUD of the entity. Its configure the labels of the User, the format of
     * fields and more.
     *
     * @param Crud $crud The CRUD to configure.
     *
     * @return Crud Crud
     */
    public function configureCrud(Crud $crud): Crud;

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * Method to get the entity FQCN of the Business. It returns the User::class.
     *
     * @return string string
     */
    public static function getEntityFqcn(): string;

}