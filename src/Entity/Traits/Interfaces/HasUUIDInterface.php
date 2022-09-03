<?php

namespace App\Entity\Traits\Interfaces;

/**
 * UUIDTrait interface
 */
interface HasUUIDInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the UUID property of the Entity.
     *
     * @return string|null string|null
     */
    public function getUUID(): ?string;

    /**
     * Sets the UUID property of the Entity.
     *
     * @param string|null $uuid UUID of the Entity to set.
     *
     * @return $this $this
     */
    public function setUUID(?string $uuid): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'uuid' => $this->getUUID()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}