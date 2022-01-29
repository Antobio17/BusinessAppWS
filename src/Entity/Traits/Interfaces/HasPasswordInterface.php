<?php

namespace App\Entity\Traits\Interfaces;

/**
 * PasswordTrait interface
 */
interface HasPasswordInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Password property of the Entity.
     *
     * @return string string
     */
    public function getPassword(): string;

    /**
     * Sets the Password property of the Entity.
     *
     * @param string $password Password of the Entity to set.
     *
     * @return $this $this
     */
    public function setPassword(string $password): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'password' => $this->getPassword()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}