<?php

namespace App\Controller\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Traits\Interfaces\HasStoreServiceInterface;

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
    public function getBusinessProducts(Request $request): JsonResponse;

    /**
     * Route to notify that a new order has been created.
     *
     * @param Request $request Request of the route.
     *
     * @return JsonResponse JsonResponse
     */
    public function notifyNewOrder(Request $request): JsonResponse;

    /**
     * Route to notify the payment status of a user order.
     *
     * @param Request $request Request of the route.
     *
     * @return JsonResponse JsonResponse
     */
    public function notifyPaymentOrder(Request $request): JsonResponse;

    /**
     * Route to cancel an order that has been created, and it has pending status.
     *
     * @param Request $request Request of the route.
     *
     * @return JsonResponse JsonResponse
     */
    public function cancelPendingOrder(Request $request): JsonResponse;

    /**
     * Route to get the categories of the business' products.
     *
     * @param Request $request Request of the route.
     *
     * @return JsonResponse JsonResponse
     */
    public function getProductCategories(Request $request): JsonResponse;

    /**
     * Route to get the orders of a user in the business.
     *
     * @param Request $request Request of the route.
     *
     * @return JsonResponse JsonResponse
     */
    public function getUserOrders(Request $request): JsonResponse;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}