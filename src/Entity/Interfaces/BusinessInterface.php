<?php

namespace App\Entity\Interfaces;

use App\Entity\Traits\Interfaces\HasNameInterface;
use App\Entity\Traits\Interfaces\HasDomainInterface;
use App\Entity\Traits\Interfaces\HasPhoneNumberInterface;
use App\Entity\Traits\Interfaces\HasPostalAddressInterface;

/**
 * Business interface.
 */
interface BusinessInterface extends HasDomainInterface, HasNameInterface, HasPhoneNumberInterface,
    HasPostalAddressInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'domain' => $this->getDomain()
     *          'name' => $this->getName()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}