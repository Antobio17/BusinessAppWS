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
     * @param bool $resultAsArray Boolean to return the result as array or as an entity.
     *
     * @return array array
     */
    public function findByUser(BusinessInterface $business, User $user, bool $resultAsArray = TRUE): array;

    /*********************************************** STATIC METHODS ***********************************************/

}