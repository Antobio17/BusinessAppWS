<?php

namespace App\Entity\Interfaces;

use App\Entity\Traits\Interfaces\HasStatusInterface;
use App\Entity\Traits\Interfaces\HasWorkerInterface;
use App\Entity\Traits\Interfaces\HasBookingDateAtInterface;

/**
 * Appointment interface.
 */
interface AppointmentInterface extends HasWorkerInterface, HasBookingDateAtInterface, HasStatusInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * Gets the status values of the entity.
     *
     *      return array(
     *          static::STATUS_PENDING,
     *          static::STATUS_CANCELLED,
     *          static::STATUS_DONE
     *      )
     *
     * @return array array
     */
    public static function getStatusValues(): array;

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