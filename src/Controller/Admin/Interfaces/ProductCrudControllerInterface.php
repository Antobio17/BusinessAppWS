<?php

namespace App\Controller\Admin\Interfaces;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;

/**
 * ProductCrudControllerInterface
 */
interface ProductCrudControllerInterface
{

    /************************************************** ROUTING ***************************************************/

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Method to configure the CRUD of the entity. Its configure the labels of the Business, the format of
     * fields and more.
     *
     * @param Crud $crud The CRUD to configure.
     *
     * @return Crud Crud
     */
    public function configureCrud(Crud $crud): Crud;

    /**
     * Method to configure the Filters of the index.
     *
     * @return Filters Filters
     */
    public function configureFilters(Filters $filters): Filters;

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * Method to get the entity FQCN of the Business. It returns the Business::class.
     *
     * @return string string
     */
    public static function getEntityFqcn(): string;

}