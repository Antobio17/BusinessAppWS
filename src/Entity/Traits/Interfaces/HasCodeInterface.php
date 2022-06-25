<?php

namespace App\Entity\Traits\Interfaces;

/**
 * CodeTrait interface
 */
interface HasCodeInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Code property of the Entity.
     *
     * @return string string
     */
    public function getCode(): string;

    /**
     * Sets the Code property of the Entity.
     *
     * @param string $code Code of the Entity to set.
     *
     * @return $this $this
     */
    public function setCode(string $code): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'code' => $this->getCode()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}