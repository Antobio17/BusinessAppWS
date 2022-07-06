<?php

namespace App\Entity\Traits\Interfaces;

/**
 * NeighborhoodTrait interface
 */
interface HasNeighborhoodInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Neighborhood property of the Entity.
     *
     * @return string|null string|null
     */
    public function getNeighborhood(): ?string;

    /**
     * Sets the Neighborhood property of the Entity.
     *
     * @param string|null $neighborhood Neighborhood of the Entity to set.
     *
     * @return $this $this
     */
    public function setNeighborhood(?string $neighborhood): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'neighborhood' => $this->getNeighborhood()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}