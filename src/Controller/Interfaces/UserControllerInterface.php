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
     * Route to verify a new user created.
     *
     * @param Request $request Request of the route.
     *
     * @return Response Response
     */
    public function verifyUser(Request $request): Response;

    /**
     * Route to access user registration in the application.
     *
     * @param Request $request Request of the route.
     *
     * @return JsonResponse JsonResponse
     */
    public function signup(Request $request): JsonResponse;

    /**
     * Route to access user login in the application.
     *
     * @param Request $request Request of the route.
     *
     * @return JsonResponse JsonResponse
     */
    public function signin(Request $request): JsonResponse;

    /**
     * Route to create a postal address for a user.
     *
     * @param Request $request Request of the route.
     *
     * @return JsonResponse JsonResponse
     */
    public function createPostalAddress(Request $request): JsonResponse;

    /**
     * Route to delete a postal address for a user.
     *
     * @param Request $request Request of the route.
     *
     * @return JsonResponse JsonResponse
     */
    public function deletePostalAddress(Request $request): JsonResponse;

    /**
     * Route to get data of the user logged.
     *
     * @param Request $request Request of the route.
     *
     * @return JsonResponse JsonResponse
     */
    public function getUserData(Request $request): JsonResponse;

    /**
     * Route to update the data of the user logged.
     *
     * @param Request $request Request of the route.
     *
     * @return JsonResponse JsonResponse
     */
    public function updateUserData(Request $request): JsonResponse;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}