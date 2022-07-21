<?php

namespace App\Repository\Interfaces;

use App\Entity\Interfaces\BusinessInterface;
use App\Entity\Interfaces\HomeConfigInterface;

interface HomeConfigRepositoryInterface
{

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Finds the HomeConfig with the specified offset and limit.
     *
     * @param BusinessInterface $business Business to which the HomeConfig belong.
     *
     * @return HomeConfigInterface|null HomeConfigInterface|null
     */
    public function findByBusiness(BusinessInterface $business): ?HomeConfigInterface;

    /*********************************************** STATIC METHODS ***********************************************/
}