<?php

namespace App\Entity\Traits\Interfaces;

/**
 * NameTrait interface
 */
interface HasNameInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Name property of the Entity.
     *
     * @return string string
     */
    public function getName(): string;

    /**
     * Sets the Name property of the Entity.
     *
     * @param string $name Name of the Entity to set.
     *
     * @return $this $this
     */
    public function setName(string $name): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'name' => $this->getName()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}