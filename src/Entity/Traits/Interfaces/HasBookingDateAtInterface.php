<?php

namespace App\Entity\Traits\Interfaces;

use DateTime;

/**
 * BookingDateAtTrait interface
 */
interface HasBookingDateAtInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the BookingDateAt property.
     *
     * @return DateTime DateTime
     */
    public function getBookingDateAt(): DateTime;

    /**
     * Sets the BookingDateAt property.
     *
     * @param DateTime $bookingDateAt The BookingDateAt to be set.
     *
     * @return $this $this
     */
    public function setBookingDateAt(DateTime $bookingDateAt): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'bookingDateAt' => $this->>getBookingDateAt()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}