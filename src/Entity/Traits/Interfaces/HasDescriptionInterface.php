<?php

namespace App\Entity\Traits\Interfaces;

/**
 * DescriptionTrait interface
 */
interface HasDescriptionInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Description property of the Entity.
     *
     * @return string string
     */
    public function getDescription(): string;

    /**
     * Sets the Description property of the Entity.
     *
     * @param string $description Description of the Entity to set.
     *
     * @return $this $this
     */
    public function setDescription(string $description): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'description' => $this->getDescription()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}