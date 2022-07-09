<?php

namespace App\Repository\Interfaces;

use App\Entity\Interfaces\BusinessInterface;

interface ProductRepositoryInterface
{

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Finds the products with the specified offset and limit.
     *
     * @param BusinessInterface $business Business to which the products belong.
     * @param int|null $offset Offset of the query.
     * @param int|null $limit Limit of the query.
     * @param bool $resultAsArray Boolean to return the result as array or as an entity.
     *
     * @return array array
     */
    public function findByOffset(BusinessInterface $business, ?int $offset = NULL, ?int $limit = NULL,
                                 bool $resultAsArray = TRUE): array;

    /**
     * Finds the Category IDs of the products of a business.
     *
     * @param BusinessInterface $business Business to which the products belong.
     *
     * @return array array
     */
    public function findProductCategoryIDs(BusinessInterface $business): array;

    /*********************************************** STATIC METHODS ***********************************************/
}