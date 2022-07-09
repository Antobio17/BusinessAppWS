<?php

namespace App\Repository\Interfaces;

use App\Entity\Interfaces\BusinessInterface;
use App\Entity\Interfaces\OrderInterface;
use App\Entity\User;

interface OrderRepositoryInterface
{

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Gets the order find by the UUID.
     *
     * @param string $UUID UUID of the order.
     *
     * @return OrderInterface|null OrderInterface|null
     */
    public function findByUUID(string $UUID): ?OrderInterface;

    /**
     * Finds the orders of a user in a business.
     *
     * @param BusinessInterface $business Business to which the products belong.
     * @param User $user The user of the business.
     * @param int|null $offset The offset of the query.
     * @param int|null $limit The limit of the query.
     * @param bool $resultAsArray Boolean to return the result as array or as an entity.
     *
     * @return array array
     */
    public function findByUser(BusinessInterface $business, User $user, ?int $offset = NULL, ?int $limit = NULL,
        bool $resultAsArray = TRUE): array;

    /**
     * Gets the count of the total orders realized by a user.
     *
     * @param BusinessInterface $business Business to which the entity belongs.
     * @param User $user The user of the orders.
     *
     * @return int int
     */
    public function getCountTotalOrders(BusinessInterface $business, User $user): int;

    /*********************************************** STATIC METHODS ***********************************************/

}