<?php

namespace App\Entity\Traits;

use App\Entity\Traits\Interfaces\HasBusinessConfigInterface;

/**
 * Trait to implement Config property.
 *
 * @see HasBusinessConfigInterface
 */
trait BusinessConfigTrait
{

    /************************************************* PROPERTIES *************************************************/

    use OpensAtTrait {
        OpensAtTrait::__construct as protected __opensAtConstruct;
        OpensAtTrait::__toArray as protected __opensAtToArray;
    }

    use ClosesAtTrait {
        ClosesAtTrait::__construct as protected __closesAtConstruct;
        ClosesAtTrait::__toArray as protected __closesAtToArray;
    }

    use AppointmentDurationTrait {
        AppointmentDurationTrait::__construct as protected __appointmentDurationConstruct;
        AppointmentDurationTrait::__toArray as protected __appointmentDurationToArray;
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  BusinessConfigTrait constructor.
     *
     * @param string $opensAt The open date for the business.
     * @param string $closesAt The close date for the business.
     * @param int $appointmentDuration The duration of the appointments.
     *
     */
    public function __construct(string $opensAt, string $closesAt, int $appointmentDuration = 60)
    {
        $this->__opensAtConstruct($closesAt);
        $this->__closesAtConstruct($closesAt);
        $this->__appointmentDurationConstruct($appointmentDuration);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array_merge(
            $this->__opensAtToArray(),
            $this->__closesAtToArray(),
            $this->__appointmentDurationToArray(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}