<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasAppointmentDurationInterface;

/**
 * Trait to implement AppointmentDuration property.
 *
 * @see HasAppointmentDurationInterface
 */
trait AppointmentDurationTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="integer", nullable=true, options={ "default": 60 })
     */
    protected int $appointmentDuration;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return int int
     */
    public function getAppointmentDuration(): int
    {
        return $this->appointmentDuration;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setAppointmentDuration(int $appointmentDuration): self
    {
        $this->appointmentDuration = $appointmentDuration;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  AppointmentDurationTrait constructor.
     *
     * @param int $appointmentDuration The appointment duration of the business.
     *
     */
    public function __construct(int $appointmentDuration = 60)
    {
        $this->setAppointmentDuration($appointmentDuration);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public
    function __toArray(): array
    {
        return array(
            'appointmentDuration' => $this->getAppointmentDuration()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}