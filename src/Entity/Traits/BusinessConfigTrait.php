<?php

namespace App\Entity\Traits;

use App\Entity\Shift;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Traits\Interfaces\HasBusinessConfigInterface;

/**
 * Trait to implement Config property.
 *
 * @see HasBusinessConfigInterface
 */
trait BusinessConfigTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * One Business has many shifts.
     *
     * @OneToMany(targetEntity="Shift", mappedBy="business", cascade={"persist"})
     */
    protected Collection $shifts;

    use AppointmentDurationTrait {
        AppointmentDurationTrait::__construct as protected __appointmentDurationConstruct;
        AppointmentDurationTrait::__toArray as protected __appointmentDurationToArray;
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return Shift[] Shift[]
     */
    public function getShifts(): Collection
    {
        return $this->shifts;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function addShift(Shift $shift): self
    {
        $this->shifts->add($shift);

        return $this;
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
        $this->__appointmentDurationConstruct($appointmentDuration);

        $this->shifts = new ArrayCollection();
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function getShiftsAsArray(): array
    {
        foreach ($this->getShifts() as $shift):
            $array[$shift->getWeekDay()][] = array(
                'opensAt' => $shift->getOpensAt(),
                'closesAt' => $shift->getClosesAt()
            );
        endforeach;

        return $array ?? array();
    }

    /**
     * @inheritDoc
     * @return bool bool
     */
    public function checkHourInShifts(int $day, string $hour): bool
    {
        $shifts = $this->getShiftsAsArray();

        if (isset($shifts[$day])):
            foreach ($shifts[$day] as $shift):
                $isInShifts = $shift['opensAt'] <= $hour && $shift['closesAt'] > $hour;
            endforeach;
        endif;

        return $isInShifts ?? FALSE;
    }

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array_merge(
            $this->getShiftsAsArray(),
            $this->__appointmentDurationToArray(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}