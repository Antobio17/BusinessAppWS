<?php

namespace App\Entity\Traits\Interfaces;

/**
 * ServicesSectionTrait interface
 */
interface HasServicesSectionInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the ServicesData property of the Entity.
     *
     * @return array array
     */
    public function getServicesData(): array;

    /**
     * Sets the ServicesData property of the Entity.
     *
     * @param array $servicesData ServicesData of the Entity to set.
     *
     * @return $this $this
     */
    public function setServicesData(array $servicesData): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'servicesData' => $this->getSectionData()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}