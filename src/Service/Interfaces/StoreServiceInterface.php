<?php

namespace App\Service\Interfaces;

interface StoreServiceInterface extends AppServiceInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Gets the appointments of a business according to the status.
     *
     * @param int|null $offset The offset of the query.
     * @param int|null $limit The limit of the query.
     *
     * @return array array
     */
    public function getBusinessProducts(?int $offset, ?int $limit): ?array;

    /**
     * Create the new order requested from the front-end.
     *
     * @param int $postalAddressID ID of the postal address of the user to send the order.
     * @param float $amount Total amount of the order.
     * @param string $UUID UUID of the order in the third-party application.
     * @param array $productsData Data of the products of the order.
     *
     * @return bool bool
     */
    public function notifyNewOrder(int $postalAddressID, float $amount, string $UUID, array $productsData): ?bool;

    /*********************************************** STATIC METHODS ***********************************************/

}