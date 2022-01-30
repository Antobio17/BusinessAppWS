<?php

namespace App\Repository\Interfaces;

use App\Entity\Interfaces\BusinessInterface;

/**
 * Interface of AppRepository.
 */
interface AppRepositoryInterface
{

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Finds the entities with the specified type.
     *
     * @param int $type Type of the entity.
     *
     * @return array array
     */
    public function findByType(int $type): array;

    /**
     * Finds the entities with the specified status.
     *
     * @param BusinessInterface $business Business to which the appointment belongs.
     * @param int|null $status Status of the entity.
     *
     * @return array array
     */
    public function findByStatus(BusinessInterface $business, ?int $status): array;

    /*********************************************** STATIC METHODS ***********************************************/

}