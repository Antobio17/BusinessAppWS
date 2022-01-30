<?php

namespace App\Service\Interfaces;

interface AppointmentServiceInterface extends AppServiceInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Gets the appointments of a business according to the status.
     *
     * @param mixed $status The status of the appointments.
     *
     * @return array array
     */
    public function getBusinessAppointments($status): ?array;

    /*********************************************** STATIC METHODS ***********************************************/

}