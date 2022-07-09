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

    /**
     * Route to notify that a new order has been created.
     *
     * @param Request $request Request of the route.
     *
     * @return Response Response
     */
    public function notifyNewOrder(Request $request): Response;

    /**
     * Route to cancel an order that has been created, and it has pending status.
     *
     * @param Request $request Request of the route.
     *
     * @return Response Response
     */
    public function cancelPendingOrder(Request $request): Response;

    /**
     * Route to get the categories of the business' products.
     *
     * @param Request $request Request of the route.
     *
     * @return Response Response
     */
    public function getProductCategories(Request $request): Response;

    /**
     * Route to get the orders of a user in the business.
     *
     * @param Request $request Request of the route.
     *
     * @return Response Response
     */
    public function getUserOrders(Request $request): Response;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}