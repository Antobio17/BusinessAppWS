<?php

namespace App\Entity\Traits\Interfaces;

/**
 * AppointmentDurationTrait interface
 */
interface HasAppointmentDurationInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the AppointmentDuration property.
     *
     * @return int int
     */
    public function getAppointmentDuration(): int;

    /**
     * Sets the AppointmentDuration property.
     *
     * @param int $appointmentDuration
     *
     * @return $this $this
     */
    public function setAppointmentDuration(int $appointmentDuration): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'appointmentDuration' => $this->getAppointmentDuration()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}