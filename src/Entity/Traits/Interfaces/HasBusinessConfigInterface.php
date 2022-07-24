<?php

namespace App\Entity\Traits\Interfaces;

/**
 * BusinessConfig interface
 */
interface HasBusinessConfigInterface extends HasDataInterface, HasAppointmentDurationInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Hours' property of the Entity.
     *
     * @return array array
     */
    public function getHours(): array;

    /**
     * Sets the Hours' property of the Entity.
     *
     * @param array $hours The data to set.
     *
     * @return $this $this
     */
    public function setHours(array $hours): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'businessConfig' => $this->getBusinessConfig()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}