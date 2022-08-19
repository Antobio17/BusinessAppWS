<?php

namespace App\Entity\Interfaces;

use App\Entity\Traits\Interfaces\HasWeekDayInterface;
use App\Entity\Traits\Interfaces\HasOpensAtInterface;
use App\Entity\Traits\Interfaces\HasClosesAtInterface;

/**
 * Shift interface.
 */
interface ShiftInterface extends HasOpensAtInterface, HasClosesAtInterface, HasWeekDayInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Business property.
     *
     * @return BusinessInterface BusinessInterface
     */
    public function getBusiness(): BusinessInterface;

    /**
     * Sets the Business property.
     *
     * @param BusinessInterface $business The Business to be set.
     *
     * @return $this $this
     */
    public function setBusiness(BusinessInterface $business): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'businessID' => $this->>getBusiness()->getID(),
     *          $this->__opensAtToArray(),
     *          $this->__closesAtToArray()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}