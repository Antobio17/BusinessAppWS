<?php

namespace App\Entity\Traits\Interfaces;

/**
 * MethodTrait interface
 */
interface HasMethodInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Method property.
     *
     * @return string string
     */
    public function getMethod(): string;

    /**
     * Sets the Method property.
     *
     * @param string $message The method to be set.
     *
     * @return $this $this
     */
    public function setMethod(string $message): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *              'method' => $this->>getMethod()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}