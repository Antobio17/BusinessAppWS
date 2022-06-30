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
     * @return array array
     */
    public function getBusinessProducts(?int $offset, ?int $limit): ?array;

    /*********************************************** STATIC METHODS ***********************************************/

}