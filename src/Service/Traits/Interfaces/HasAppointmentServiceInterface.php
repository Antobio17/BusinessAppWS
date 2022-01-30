<?php

namespace App\Service\Traits\Interfaces;

use App\Service\Interfaces\AppointmentServiceInterface;

/**
 * AppointmentServiceTrait interface.
 */
interface HasAppointmentServiceInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the property AppointmentService.
     *
     * @return AppointmentServiceInterface AppointmentServiceInterface
     */
    public function getAppointmentService(): AppointmentServiceInterface;

    /**
     * Sets the property AppointmentService.
     *
     * @param AppointmentServiceInterface $appointmentService The service of Appointment to set.
     *
     * @return $this $this
     */
    public function setAppointmentService(AppointmentServiceInterface $appointmentService): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}