<?php

namespace App\Service\Traits;

use App\Service\Interfaces\AppointmentServiceInterface;
use App\Service\Traits\Interfaces\HasAppointmentServiceInterface;

/**
 * Trait to implement Appointment property.
 *
 * @see HasAppointmentServiceInterface
 */
trait AppointmentServiceTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var AppointmentServiceInterface
     */
    protected AppointmentServiceInterface $appointmentService;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return AppointmentServiceInterface AppointmentServiceInterface
     */
    public function getAppointmentService(): AppointmentServiceInterface
    {
        return $this->appointmentService;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setAppointmentService(AppointmentServiceInterface $appointmentService): self
    {
        $this->appointmentService = $appointmentService;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}