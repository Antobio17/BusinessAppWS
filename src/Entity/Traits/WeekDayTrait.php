<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasWeekDayInterface;

/**
 * Trait to implement WeekDayTrait property.
 *
 * @see HasWeekDayInterface
 */
trait WeekDayTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="integer", options={ "default": 0 })
     */
    protected int $weekDay;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return int int
     */
    public function getWeekDay(): int
    {
        return $this->weekDay;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setWeekDay(int $weekDay): self
    {
        $this->weekDay = $weekDay;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  WeekDayTrait constructor.
     */
    public function __construct(int $weekDay = 0)
    {
        $this->setWeekDay($weekDay);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'weekDay' => $this->getWeekDay(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}