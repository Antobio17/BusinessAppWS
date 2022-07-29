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
     * @param string|null $sort The type of sort to return the products.
     * @param bool $onStock Include the products with stock available.
     * @param bool $outOfStock Include the products with stock not available.
     * @param array $categoryExclusion The categories selected to exclude from search.
     *
     * @return array array
     */
    public function getBusinessProducts(?int $offset = NULL, ?int $limit = NULL, ?string $sort = NULL,
                                        bool $onStock = TRUE, bool $outOfStock = TRUE,
                                        array $categoryExclusion = array()): ?array;

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

    /**
     * Cancel a user's order that it is in pending status.
     *
     * @param int $orderID ID of the order to cancel.
     *
     * @return bool bool
     */
    public function cancelPendingOrder(int $orderID): ?bool;

    /**
     * Gets the categories of the business' product.
     *
     * @return array array
     */
    public function getProductCategories(): ?array;

    /**
     * Gets the orders of a user in the business.
     *
     * @param int|null $offset The offset of the query.
     * @param int|null $limit The limit of the query.
     *
     * @return array array
     */
    public function getUserOrders(?int $offset = NULL, ?int $limit = NULL): ?array;

    /*********************************************** STATIC METHODS ***********************************************/

}