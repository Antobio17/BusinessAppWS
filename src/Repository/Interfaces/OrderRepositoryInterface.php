<?php

namespace App\Repository\Interfaces;

use App\Entity\Interfaces\OrderInterface;

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

    /*********************************************** STATIC METHODS ***********************************************/

}