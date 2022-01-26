<?php

namespace App\Entity\Traits\Interfaces;

/**
 * PopulationTrait interface
 */
interface HasPopulationInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Population property of the Entity.
     *
     * @return string string
     */
    public function getPopulation(): string;

    /**
     * Sets the Population property of the Entity.
     *
     * @param string $population Population of the Entity to set.
     *
     * @return $this $this
     */
    public function setPopulation(string $population): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'population' => $this->getPopulation()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}