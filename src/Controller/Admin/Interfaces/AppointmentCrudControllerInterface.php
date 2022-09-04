<?php

namespace App\Controller\Admin\Interfaces;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * AppointmentCrudControllerInterface
 */
interface AppointmentCrudControllerInterface
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

    /**
     * Method to finish an appointment.
     *
     * @param Request $request Request of the page.
     *
     * @return RedirectResponse RedirectResponse
     */
    public function finishAppointmentAction(Request $request): RedirectResponse;

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * Method to get the entity FQCN of the Business. It returns the Business::class.
     *
     * @return string string
     */
    public static function getEntityFqcn(): string;

}