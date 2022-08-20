<?php

namespace App\Entity;

use App\Entity\Traits\WeekDayTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ShiftRepository;
use Doctrine\ORM\Mapping\ManyToOne;
use App\Entity\Traits\OpensAtTrait;
use App\Entity\Traits\ClosesAtTrait;
use Doctrine\ORM\Mapping\JoinColumn;
use App\Entity\Interfaces\ShiftInterface;
use App\Entity\Interfaces\BusinessInterface;

/**
 * Shift entity.
 *
 * @ORM\Entity(repositoryClass=ShiftRepository::class)
 */
class Shift extends AbstractORM implements ShiftInterface
{

    /************************************************* CONSTANTS **************************************************/

    public const SUNDAY = 0;
    public const MONDAY = 1;
    public const TUESDAY = 2;
    public const WEDNESDAY = 3;
    public const THURSDAY = 4;
    public const FRIDAY = 5;
    public const SATURDAY = 6;

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ManyToOne(targetEntity="App\Entity\Business", inversedBy="shifts")
     * @JoinColumn(name="business_id", referencedColumnName="id", nullable=false)
     */
    protected BusinessInterface $business;

    use OpensAtTrait {
        OpensAtTrait::__construct as protected __opensAtConstruct;
        OpensAtTrait::__toArray as protected __opensAtToArray;
    }

    use ClosesAtTrait {
        ClosesAtTrait::__construct as protected __closesAtConstruct;
        ClosesAtTrait::__toArray as protected __closesAtToArray;
    }

    use WeekDayTrait {
        WeekDayTrait::__construct as protected __weekDayConstruct;
        WeekDayTrait::__toArray as protected __weekDayToArray;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  Shift constructor.
     *
     * @param BusinessInterface $business Business to belong.
     * @param string $opensAt Business shift opening time.
     * @param string $closesAt Business shift closing time.
     */
    public function __construct(BusinessInterface $business, string $opensAt, string $closesAt, int $weekDay)
    {
        $this->__opensAtConstruct($opensAt);
        $this->__closesAtConstruct($closesAt);
        $this->__weekDayConstruct($weekDay);

        $this->setBusiness($business);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return BusinessInterface BusinessInterface
     */
    public function getBusiness(): BusinessInterface
    {
        return $this->business;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setBusiness(BusinessInterface $business): self
    {
        $this->business = $business;

        return $this;
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getWeekDayFormatted(): string
    {
        return array_flip(static::getDaysChoices())[$this->getWeekDay()];
    }

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array_merge(
            parent::__toArray(),
            $this->__opensAtToArray(),
            $this->__closesAtToArray(),
            $this->__weekDayToArray(),
            array(
                'businessID' => $this->getBusiness()->getID()
            ),
        );
    }

    /**
     * @inheritDoc
     * @return string string
     */
    public function __toString(): string
    {
        return sprintf(
            '%s de %s a %s',
            $this->getWeekDayFormatted(),
            $this->getOpensAt(),
            $this->getClosesAt()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * @return int[] int[]
     */
    static function getDaysChoices(): array{
        return array(
            'Lunes' => static::MONDAY,
            'Martes' => static::TUESDAY,
            'Miércoles' => static::WEDNESDAY,
            'Jueves' => static::THURSDAY,
            'Viernes' => static::FRIDAY,
            'Sábado' => static::SATURDAY,
            'Domingo' => static::SUNDAY,
        );
    }
}