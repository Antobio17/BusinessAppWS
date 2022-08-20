<?php

namespace App\Entity\Traits\Interfaces;

/**
 * AltTrait interface
 */
interface HasAltInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Alt property of the Entity.
     *
     * @return string string
     */
    public function getAlt(): string;

    /**
     * Sets the Alt property of the Entity.
     *
     * @param string $alt Alt of the Entity to set.
     *
     * @return $this $this
     */
    public function setAlt(string $alt): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'alt' => $this->getAlt()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}