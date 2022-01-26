<?php

namespace App\Entity\Traits\Interfaces;

/**
 * PhoneNumberTrait interface
 */
interface HasPhoneNumberInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the PhoneNumber property of the Entity.
     *
     * @return string string
     */
    public function getPhoneNumber(): string;

    /**
     * Sets the PhoneNumber property of the Entity.
     *
     * @param string $phoneNumber PhoneNumber of the Entity to set.
     *
     * @return $this $this
     */
    public function setPhoneNumber(string $phoneNumber): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'phoneNumber' => $this->getPhoneNumber()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}