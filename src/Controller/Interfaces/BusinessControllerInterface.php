<?php

namespace App\Controller\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\Traits\Interfaces\HasBusinessServiceInterface;

interface BusinessControllerInterface extends HasBusinessServiceInterface
{

    /************************************************** ROUTING ***************************************************/

    /**
     * Route to access to the business' home config of the application.
     *
     * @param Request $request Request of the route.
     *
     * @return Response Response
     */
    public function getBusinessHomeConfig(Request $request): Response;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}