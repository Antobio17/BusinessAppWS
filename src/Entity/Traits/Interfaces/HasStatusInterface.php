<?php

namespace App\Entity\Traits\Interfaces;

use App\Entity\Traits\StatusTrait;

/**
 * StatusTrait interface
 */
interface HasStatusInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Status property.
     *
     * @return int int
     */
    public function getStatus(): int;

    /**
     * Sets the Status property.
     *
     * @param int $status The Status to be set.
     *
     * @return $this $this
     */
    public function setStatus(int $status): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'status' => $this->>getStatus()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}