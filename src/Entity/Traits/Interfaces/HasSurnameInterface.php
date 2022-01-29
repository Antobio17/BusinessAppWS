<?php

namespace App\Entity\Traits\Interfaces;

/**
 * SurnameTrait interface
 */
interface HasSurnameInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Surname property of the Entity.
     *
     * @return string string
     */
    public function getSurname(): string;

    /**
     * Sets the Surname property of the Entity.
     *
     * @param string $surname Surname of the Entity to set.
     *
     * @return $this $this
     */
    public function setSurname(string $surname): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'surname' => $this->getSurname()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}