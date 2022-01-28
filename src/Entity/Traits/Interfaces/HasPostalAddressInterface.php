<?php

namespace App\Entity\Traits\Interfaces;

use App\Entity\PostalAddress;

/**
 * PostalAddressTrait interface
 */
interface HasPostalAddressInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the PostalAddress property of the Entity.
     *
     * @return PostalAddress|null PostalAddress|null
     */
    public function getPostalAddress(): ?PostalAddress;

    /**
     * Sets the PostalAddress property of the Entity.
     *
     * @param PostalAddress $postalAddress PostalAddress of the Entity to set.
     *
     * @return $this $this
     */
    public function setPostalAddress(PostalAddress $postalAddress): self;

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