<?php

namespace App\Repository\Interfaces;

use App\Entity\Interfaces\BusinessInterface;

interface BusinessRepositoryInterface
{

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Finds a Business searching by the domain passed.
     *
     * @param string $domain Domain to the searching.
     *
     * @return BusinessInterface|null BusinessInterface|null
     */
    public function findByDomain(string $domain): ?BusinessInterface;

    /*********************************************** STATIC METHODS ***********************************************/
}