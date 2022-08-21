<?php

namespace App\Repository\Interfaces;

interface CategoryRepositoryInterface
{

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Gets the categories by the IDs passed.
     *
     * @param array $categoryIDs Array of the IDs.
     * @param bool $resultAsArray Boolean to return the result as array or as an entity.
     *
     * @return array
     */
    public function findByIDs(array $categoryIDs, bool $resultAsArray = FALSE): array;

    /*********************************************** STATIC METHODS ***********************************************/
}