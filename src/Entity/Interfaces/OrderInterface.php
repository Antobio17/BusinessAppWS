<?php

namespace App\Entity\Interfaces;

use App\Entity\Traits\Interfaces\HasAmountInterface;
use App\Entity\Traits\Interfaces\HasClientSecretInterface;
use App\Entity\Traits\Interfaces\HasCreatedAtInterface;
use App\Entity\Traits\Interfaces\HasDataInterface;
use App\Entity\Traits\Interfaces\HasPostalAddressInterface;
use App\Entity\Traits\Interfaces\HasSentAtInterface;
use App\Entity\Traits\Interfaces\HasStatusInterface;
use App\Entity\Traits\Interfaces\HasUUIDInterface;

/**
 * Order interface.
 */
interface OrderInterface extends UserContextInterface, HasPostalAddressInterface, HasAmountInterface,
    HasStatusInterface, HasCreatedAtInterface, HasSentAtInterface, HasUUIDInterface, HasDataInterface,
    HasClientSecretInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * Gets the status choices of the entity.
     *
     *      return array(
     *          'Pendiente' => static::STATUS_PENDING,
     *          'En Preparación' => static::STATUS_PREPARING,
     *          'Cancelado' => static::STATUS_CANCELLED,
     *          'Enviado' => static::STATUS_SENT,
     *          'Entregado' => static::STATUS_DELIVERED
     *      )
     *
     * @return array array
     */
    public static function getStatusChoices(): array;

}