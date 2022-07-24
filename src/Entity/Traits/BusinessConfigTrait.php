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

    use DataTrait {
        DataTrait::__construct as protected __hoursConstruct;
        DataTrait::__toArray as protected __hoursToArray;
    }

    use AppointmentDurationTrait {
        AppointmentDurationTrait::__construct as protected __appointmentDurationConstruct;
        AppointmentDurationTrait::__toArray as protected __appointmentDurationToArray;
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function getHours(): array
    {
        return $this->getData();
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setHours(array $hours): self
    {
        return $this->setData($hours);
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  BusinessConfigTrait constructor.
     *
     * @param array $hours Hours of the business.
     * @param int $appointmentDuration The duration of the appointments.
     *
     */
    public function __construct(array $hours, int $appointmentDuration = 60)
    {
        $this->__hoursConstruct($hours);
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
            $this->__hoursToArray(),
            $this->__appointmentDurationToArray(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}