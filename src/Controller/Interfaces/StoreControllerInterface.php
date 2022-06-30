<?php

namespace App\Controller\Interfaces;

use App\Service\Traits\Interfaces\HasStoreServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface StoreControllerInterface extends HasStoreServiceInterface
{

    /************************************************** ROUTING ***************************************************/

    /**
     * Route to access to the business' products of the application.
     *
     * @param Request $request Request of the route.
     *
     * @return JsonResponse JsonResponse
     */
    public function getBusinessProducts(Request $request): Response;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}