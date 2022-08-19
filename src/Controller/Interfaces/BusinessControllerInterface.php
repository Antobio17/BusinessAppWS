<?php

namespace App\Controller\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Traits\Interfaces\HasBusinessServiceInterface;

interface BusinessControllerInterface extends HasBusinessServiceInterface
{

    /************************************************** ROUTING ***************************************************/

    /**
     * Route to access to the business' home config of the application.
     *
     * @param Request $request Request of the route.
     *
     * @return JsonResponse JsonResponse
     */
    public function getBusinessHomeConfig(Request $request): JsonResponse;

    /**
     * Route to access to the business' hours config of the application.
     *
     * @param Request $request Request of the route.
     *
     * @return JsonResponse JsonResponse
     */
    public function getBusinessScheduleConfig(Request $request): JsonResponse;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}