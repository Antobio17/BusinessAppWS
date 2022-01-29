<?php

namespace App\Entity\Traits\Interfaces;

/**
 * EmailTrait interface
 */
interface HasEmailInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Email property of the Entity.
     *
     * @return string string
     */
    public function getEmail(): string;

    /**
     * Sets the Email property of the Entity.
     *
     * @param string $email Email of the Entity to set.
     *
     * @return $this $this
     */
    public function setEmail(string $email): self;

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