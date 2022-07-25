<?php

namespace App\Controller\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Traits\Interfaces\HasAppointmentServiceInterface;

interface AppointmentControllerInterface extends HasAppointmentServiceInterface
{

    /************************************************** ROUTING ***************************************************/

    /**
     * Route to access to the business' appointments of the application.
     *
     * @param Request $request Request of the route.
     *
     * @return JsonResponse JsonResponse
     */
    public function getBusinessAppointments(Request $request): JsonResponse;

    /**
     * Route to access to the users' appointments of the application.
     *
     * @param Request $request Request of the route.
     *
     * @return JsonResponse JsonResponse
     */
    public function getUserAppointments(Request $request): JsonResponse;

    /**
     * Route to access to the workers' appointments of the application.
     *
     * @param Request $request Request of the route.
     *
     * @return JsonResponse JsonResponse
     */
    public function getWorkerAppointments(Request $request): JsonResponse;

    /**
     * Route to book an appointment to a user.
     *
     * @param Request $request Request of the route.
     *
     * @return JsonResponse JsonResponse
     */
    public function bookUserAppointment(Request $request): JsonResponse;

    /**
     * Route to cancel a user's booked appointment.
     *
     * @param Request $request Request of the route.
     *
     * @return JsonResponse JsonResponse
     */
    public function cancelUserBookedAppointment(Request $request): JsonResponse;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}