<?php

namespace App\Entity\Interfaces;

use App\Entity\Traits\Interfaces\HasAmountInterface;
use App\Entity\Traits\Interfaces\HasCreatedAtInterface;
use App\Entity\Traits\Interfaces\HasPostalAddressInterface;
use App\Entity\Traits\Interfaces\HasSentAtInterface;
use App\Entity\Traits\Interfaces\HasStatusInterface;
use App\Entity\Traits\Interfaces\HasUUIDInterface;

/**
 * Order interface.
 */
interface OrderInterface extends HasPostalAddressInterface, HasAmountInterface, HasStatusInterface,
    HasCreatedAtInterface, HasSentAtInterface, HasUUIDInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}