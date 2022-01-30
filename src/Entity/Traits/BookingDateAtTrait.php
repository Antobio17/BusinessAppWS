<?php

namespace App\Entity\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Trait to implement BookingDateAtTrait property.
 *
 * @see HasBookingDateAtInterface
 */
trait BookingDateAtTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected DateTime $bookingDateAt;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return DateTime DateTime
     */
    public function getBookingDateAt(): DateTime
    {
        return $this->bookingDateAt;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setBookingDateAt(DateTime $bookingDateAt): self
    {
        $this->bookingDateAt = $bookingDateAt;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  BookingDateAtTrait constructor.
     */
    public function __construct(DateTime $bookingDateAt)
    {
        $this->setBookingDateAt($bookingDateAt);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'bookingDateAt' => $this->getBookingDateAt(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}