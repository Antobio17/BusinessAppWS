<?php

namespace App\Repository\Interfaces;

use DateTime;
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
     * @param BusinessInterface $business Business to which the entity belongs.
     * @param int|null $status Status of the entity.
     * @param UserInterface|null $user User of the entity.
     * @param bool $isWorker Boolean to know if the user is a worker.
     * @param DateTime|null $startDate The start date to search.
     * @param DateTime|null $endDate The end date to search.
     * @param bool $resultAsArray Boolean to return the result as array or as an entity.
     *
     * @return array array
     */
    public function findByStatus(BusinessInterface $business, ?int $status = NULL, ?UserInterface $user = NULL,
                                 bool              $isWorker = FALSE, ?DateTime $startDate = NULL,
                                 ?DateTime         $endDate = NULL, bool $resultAsArray = TRUE): array;

    /**
     * Gets the count of a collection in the business context.
     *
     * @param BusinessInterface $business Business to which the entity belongs.
     *
     * @return int int
     */
    public function getCount(BusinessInterface $business): int;

    /*********************************************** STATIC METHODS ***********************************************/

}