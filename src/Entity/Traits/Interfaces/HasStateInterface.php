<?php

namespace App\Entity\Traits\Interfaces;

/**
 * StateTrait interface
 */
interface HasStateInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the State property of the Entity.
     *
     * @return string string
     */
    public function getState(): string;

    /**
     * Sets the State property of the Entity.
     *
     * @param string $state State of the Entity to set.
     *
     * @return $this $this
     */
    public function setState(string $state): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'State' => $this->getstate()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}