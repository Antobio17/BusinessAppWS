<?php

namespace App\Controller\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Traits\Interfaces\HasUserServiceInterface;

interface UserControllerInterface extends HasUserServiceInterface
{

    /************************************************** ROUTING ***************************************************/

    /**
     * Route to access user registration in the application.
     *
     * @param Request $request Request of the route.
     *
     * @return Response Response
     */
    public function signup(Request $request): Response;

    /**
     * Route to access user login in the application.
     *
     * @param Request $request Request of the route.
     *
     * @return Response Response
     */
    public function signin(Request $request): Response;

    /**
     * Route to create a postal address for a user.
     *
     * @param Request $request Request of the route.
     *
     * @return Response Response
     */
    public function createPostalAddress(Request $request): Response;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}