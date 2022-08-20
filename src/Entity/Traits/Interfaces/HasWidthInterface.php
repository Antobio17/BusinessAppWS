<?php

namespace App\Entity\Traits\Interfaces;

/**
 * WidthTrait interface
 */
interface HasWidthInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Width property.
     *
     * @return int int
     */
    public function getWidth(): int;

    /**
     * Sets the Width property.
     *
     * @param int $width The Width to be set.
     *
     * @return $this $this
     */
    public function setWidth(int $width): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'width' => $this->>getWidth()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}