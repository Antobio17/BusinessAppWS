<?php

namespace App\Entity\Traits\Interfaces;

/**
 * PostalCodeTrait interface
 */
interface HasPostalCodeInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the PostalCode property of the Entity.
     *
     * @return string string
     */
    public function getPostalCode(): string;

    /**
     * Sets the PostalCode property of the Entity.
     *
     * @param string $postalCode PostalCode of the Entity to set.
     *
     * @return $this $this
     */
    public function setPostalCode(string $postalCode): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'postalCode' => $this->getPostalCode()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}