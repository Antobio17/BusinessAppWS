<?php

namespace App\Entity\Traits\Interfaces;

/**
 * AddressTrait interface
 */
interface HasAddressInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Address property of the Entity.
     *
     * @return string string
     */
    public function getAddress(): string;

    /**
     * Sets the Address property of the Entity.
     *
     * @param string $address Address of the Entity to set.
     *
     * @return $this $this
     */
    public function setAddress(string $address): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'address' => $this->getAddress()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}