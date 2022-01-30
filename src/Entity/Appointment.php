<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\WorkerTrait;
use App\Entity\Traits\StatusTrait;
use App\Entity\Traits\BookingDateAtTrait;
use App\Repository\AppointmentRepository;
use App\Entity\Interfaces\BusinessInterface;
use App\Entity\Interfaces\AppointmentInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Appointment entity.
 *
 * @ORM\Entity(repositoryClass=AppointmentRepository::class)
 */
class Appointment extends AbstractUserContext implements AppointmentInterface
{

    /************************************************* CONSTANTS **************************************************/

    public const STATUS_PENDING = 0;
    public const STATUS_CANCELLED = 1;
    public const STATUS_DONE = 2;

    /************************************************* PROPERTIES *************************************************/

    use WorkerTrait {
        WorkerTrait::__construct as protected __workerConstruct;
        WorkerTrait::__toArray as protected __workerToArray;
    }

    use BookingDateAtTrait {
        BookingDateAtTrait::__construct as protected __bookingDateAtConstruct;
        BookingDateAtTrait::__toArray as protected __bookingDateAtToArray;
    }

    use StatusTrait {
        StatusTrait::__construct as protected __statusConstruct;
        StatusTrait::__toArray as protected __statusToArray;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  Appointment constructor.
     */
    public function __construct(BusinessInterface $business, UserInterface $user, UserInterface $worker,
                                DateTime $bookingDateAt, int $status = 0)
    {
        parent::__construct($business, $user);

        $this->__workerConstruct($worker);
        $this->__bookingDateAtConstruct($bookingDateAt);
        $this->__statusConstruct($status);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array_merge(
            parent::__toArray(),
            $this->__workerToArray(),
            $this->__bookingDateAtToArray(),
            $this->__statusToArray(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public static function getStatusChoices(): array
    {
        return array(
            'Pendiente' => static::STATUS_PENDING,
            'Cancelada' => static::STATUS_CANCELLED,
            'Terminada' => static::STATUS_DONE,
        );
    }

}