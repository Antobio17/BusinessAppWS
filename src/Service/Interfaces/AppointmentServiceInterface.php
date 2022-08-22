<?php

namespace App\Service\Interfaces;

use App\Entity\Appointment;
use DateTime;

interface AppointmentServiceInterface extends AppServiceInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Gets the appointments of a business according to the status.
     *
     * @param mixed $status The status of the appointments.
     * @param DateTime|null $startDate The start date to filter the query.
     * @param DateTime|null $endDate The end date to filter the query.
     *
     * @return array array
     */
    public function getBusinessAppointments($status, ?DateTime $startDate = NULL, ?DateTime $endDate = NULL): ?array;

    /**
     * Gets the appointments of a user/worker according to the status.
     *
     * @param mixed $status The status of the appointments.
     * @param bool $isWorker Boolean to know if the user is a worker.
     *
     * @return array array
     */
    public function getUserAppointments($status, bool $isWorker = FALSE): ?array;

    /**
     * Book a user's appointment if it is a valid date for the reservation.
     *
     * @param DateTime $bookingDateAt The dato of the book.
     * @param string|null $phoneNumber User's email in case the reservation is made by the worker.
     *
     * @return Appointment|null Appointment|null
     */
    public function bookUserAppointment(DateTime $bookingDateAt, ?string $phoneNumber = NULL): ?Appointment;

    /**
     * Cancel a user's book appointment in case the user have one.
     *
     * @param string|null $userEmail User's email in case the cancellation is made by the worker.
     *
     * @return bool bool
     */
    public function cancelUserBookedAppointment(?string $userEmail = NULL): bool;

    /*********************************************** STATIC METHODS ***********************************************/

}