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
     * @param string|null $sort The type of sort to return the products.
     * @param bool $onStock Include the products with stock available.
     * @param bool $outOfStock Include the products with stock not available.
     * @param array $categoryExclusion The categories selected to exclude from search.
     * @param bool $resultAsArray Boolean to return the result as array or as an entity.
     *
     * @return array array
     */
    public function findByFilters(BusinessInterface $business, ?int $offset = NULL, ?int $limit = NULL,
                                  ?string           $sort = NULL, bool $onStock = TRUE, bool $outOfStock = TRUE,
                                  array             $categoryExclusion = array(), bool $resultAsArray = TRUE): array;

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