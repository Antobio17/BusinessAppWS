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

    /**
     * Gets the appointments of a user according to the status.
     *
     * @param mixed $status The status of the appointments.
     *
     * @return array array
     */
    public function getUserAppointments($status): ?array;

    /*********************************************** STATIC METHODS ***********************************************/

}