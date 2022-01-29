<?php

namespace App\Entity\Traits\Interfaces;

use App\Entity\Interfaces\PostalAddressInterface;

/**
 * PostalAddressTrait interface
 */
interface HasPostalAddressInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the PostalAddress property of the Entity.
     *
     * @return PostalAddressInterface|null PostalAddressInterface|null
     */
    public function getPostalAddress(): ?PostalAddressInterface;

    /**
     * Sets the PostalAddress property of the Entity.
     *
     * @param PostalAddressInterface $postalAddress PostalAddress of the Entity to set.
     *
     * @return $this $this
     */
    public function setPostalAddress(PostalAddressInterface $postalAddress): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'postalAddress' => $this->getPostalAddress()->__toArray()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}