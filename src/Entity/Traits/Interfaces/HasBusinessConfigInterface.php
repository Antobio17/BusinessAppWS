<?php

namespace App\Entity\Traits\Interfaces;

use App\Entity\Shift;
use Doctrine\Common\Collections\Collection;

/**
 * BusinessConfig interface
 */
interface HasBusinessConfigInterface extends HasAppointmentDurationInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Shifts' property of the Entity.
     *
     * @return Collection Shift[]
     */
    public function getShifts(): Collection;

    /**
     * Add a shift to the property of the Entity.
     *
     * @param Shift $shift The shift to add.
     *
     * @return $this $this
     */
    public function addShift(Shift $shift): self;

    /**
     * Remove a shift from the property of the Entity.
     *
     * @param Shift $shift The shift to remove.
     *
     * @return $this $this
     */
    public function removeShift(Shift $shift): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Gets the shifts of the business as array.
     *
     * @return array array
     */
    public function getShiftsAsArray(): array;

    /**
     * Checks if an hour specified is in the range of shifts.
     *
     * @param int $day The day of the shifts.
     * @param string $hour Hour to check.
     *
     * @return bool bool
     */
    public function checkHourInShifts(int $day, string $hour): bool;

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'businessConfig' => $this->getBusinessConfig()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}