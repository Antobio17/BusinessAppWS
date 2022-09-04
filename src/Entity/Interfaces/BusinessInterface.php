<?php

namespace App\Entity\Interfaces;

use App\Entity\Traits\Interfaces\HasClientSecretInterface;
use App\Entity\Traits\Interfaces\HasDomainAliasInterface;
use App\Entity\Traits\Interfaces\HasNameInterface;
use App\Entity\Traits\Interfaces\HasDomainInterface;
use App\Entity\Traits\Interfaces\HasPhoneNumberInterface;
use App\Entity\Traits\Interfaces\HasEmailNullableInterface;
use App\Entity\Traits\Interfaces\HasPostalAddressInterface;
use App\Entity\Traits\Interfaces\HasBusinessConfigInterface;

/**
 * Business interface.
 */
interface BusinessInterface extends HasDomainInterface, HasNameInterface, HasPhoneNumberInterface,
    HasEmailNullableInterface, HasPostalAddressInterface, HasBusinessConfigInterface, HasClientSecretInterface,
    HasDomainAliasInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          $this->__domainToArray(),
     *          $this->__nameToArray(),
     *          $this->__phoneNumberToArray(),
     *          $this->__emailToArray(),
     *          $this->__postalAddressToArray(),
     *          $this->__configToArray()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /**
     * Gets the Display Name of the entity.
     *
     * @return string string
     */
    public function __toString(): string;

    /*********************************************** STATIC METHODS ***********************************************/

}