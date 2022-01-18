<?php

namespace App\Repository\Interfaces;

/**
 * Interface of AppRepository.
 */
interface AppRepositoryInterface
{

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Finds the errors with the specified type.
     *
     * @param int $type Type of the error.
     *
     * @return array array
     */
    public function findByType(int $type): array;

    /*********************************************** STATIC METHODS ***********************************************/

}