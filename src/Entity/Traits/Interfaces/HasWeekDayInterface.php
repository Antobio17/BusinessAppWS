<?php

namespace App\Entity\Traits\Interfaces;

/**
 * WeekDayTrait interface
 */
interface HasWeekDayInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the WeekDay property.
     *
     * @return int int
     */
    public function getWeekDay(): int;

    /**
     * Sets the WeekDay property.
     *
     * @param int $weekDay The WeekDay to be set.
     *
     * @return $this $this
     */
    public function setWeekDay(int $weekDay): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'weekDay' => $this->>getWeekDay()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}