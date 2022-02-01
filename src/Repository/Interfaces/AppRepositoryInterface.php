<?php

namespace App\Repository\Interfaces;

use App\Entity\Interfaces\BusinessInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @param UserInterface|null $user User of the entity.
     * @param bool $isWorker Boolean to know if the user is a worker.
     *
     * @return array array
     */
    public function findByStatus(BusinessInterface $business, ?int $status = NULL, ?UserInterface $user = NULL,
                                 bool $isWorker = FALSE): array;

    /*********************************************** STATIC METHODS ***********************************************/

}