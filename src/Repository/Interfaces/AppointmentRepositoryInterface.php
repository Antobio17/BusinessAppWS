<?php

namespace App\Repository\Interfaces;

use App\Entity\Appointment;
use App\Entity\Interfaces\BusinessInterface;
use DateTime;
use Symfony\Component\Security\Core\User\UserInterface;

interface AppointmentRepositoryInterface
{

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Gets the appointment with the date passed if exists.
     *
     * @param BusinessInterface $business Business of the appointment.
     * @param DateTime $bookingDateAt Booking date of the appointment.
     * @param UserInterface|null $user User of the appointment.
     * @param bool $isWorker Boolean to find by worker or user.
     *
     * @return Appointment Appointment
     */
    public function findByBookingDate(BusinessInterface $business, DateTime $bookingDateAt,
                                      ?UserInterface    $user = NULL, bool $isWorker = FALSE): ?Appointment;

    /*********************************************** STATIC METHODS ***********************************************/
}