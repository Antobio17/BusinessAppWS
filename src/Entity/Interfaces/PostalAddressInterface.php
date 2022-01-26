<?php

namespace App\Entity\Interfaces;

use App\Entity\Traits\Interfaces\HasNameInterface;
use App\Entity\Traits\Interfaces\HasStateInterface;
use App\Entity\Traits\Interfaces\HasAddressInterface;
use App\Entity\Traits\Interfaces\HasPopulationInterface;
use App\Entity\Traits\Interfaces\HasPostalCodeInterface;
use App\Entity\Traits\Interfaces\HasNeighborhoodInterface;

/**
 * PostalAddress interface.
 */
interface PostalAddressInterface extends HasNameInterface, HasAddressInterface, HasNeighborhoodInterface,
    HasPostalCodeInterface, HasPopulationInterface, HasStateInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}