<?php

namespace App\Entity\Traits\Interfaces;

/**
 * HeightTrait interface
 */
interface HasHeightInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Height property.
     *
     * @return int int
     */
    public function getHeight(): int;

    /**
     * Sets the Height property.
     *
     * @param int $height The Height to be set.
     *
     * @return $this $this
     */
    public function setHeight(int $height): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'height' => $this->>getHeight()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}