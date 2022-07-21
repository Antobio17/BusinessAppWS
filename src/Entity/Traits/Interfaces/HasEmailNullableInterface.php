<?php

namespace App\Entity\Traits\Interfaces;

/**
 * EmailNullableTrait interface
 */
interface HasEmailNullableInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Email property of the Entity.
     *
     * @return string|null string|null
     */
    public function getEmail(): ?string;

    /**
     * Sets the Email property of the Entity.
     *
     * @param string|null $email Email of the Entity to set.
     *
     * @return $this $this
     */
    public function setEmail(?string $email): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'email' => $this->getEmail()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}