<?php

namespace App\Entity\Interfaces;

/**
 * Appointment interface.
 */
interface AppointmentInterface extends UserContextInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * Gets the status choices of the entity.
     *
     *      return array(
     *          'Pendiente' => static::STATUS_PENDING,
     *          'Cancelada' => static::STATUS_CANCELLED,
     *          'Terminada' => static::STATUS_DONE
     *      )
     *
     * @return array array
     */
    public static function getStatusChoices(): array;

}