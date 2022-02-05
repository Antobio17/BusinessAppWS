<?php

namespace App\Entity\Traits\Interfaces;

use DateTime;

/**
 * ClosesAtTrait interface
 */
interface HasClosesAtInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the ClosesAt property.
     *
     * @return string string
     */
    public function getClosesAt(): string;

    /**
     * Sets the ClosesAt property.
     *
     * @param string $closesAt The closes date to be set.
     *
     * @return $this $this
     */
    public function setClosesAt(string $closesAt): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'closesAt' => $this->getClosesAt()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}