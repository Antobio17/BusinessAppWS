<?php

namespace App\Controller\Interfaces;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface AppointmentControllerInterface
{

    /************************************************** ROUTING ***************************************************/

    /**
     * Route to access to the business' appointments of the application.
     *
     * @param Request $request Request of the route.
     *
     * @return JsonResponse JsonResponse
     */
    public function getBusinessAppointments(Request $request): Response;

    /**
     * Route to access to the users' appointments of the application.
     *
     * @param Request $request Request of the route.
     *
     * @return JsonResponse JsonResponse
     */
    public function getUserAppointments(Request $request): Response;

    /**
     * Route to access to the workers' appointments of the application.
     *
     * @param Request $request Request of the route.
     *
     * @return JsonResponse JsonResponse
     */
    public function getWorkerAppointments(Request $request): Response;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}