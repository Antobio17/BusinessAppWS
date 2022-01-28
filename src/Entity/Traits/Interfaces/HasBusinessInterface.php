<?php

namespace App\Entity\Traits\Interfaces;

use App\Entity\Interfaces\BusinessInterface;

/**
 * BusinessTrait interface
 */
interface HasBusinessInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Business property.
     *
     * @return BusinessInterface|null BusinessInterface|null
     */
    public function getBusiness(): ?BusinessInterface;

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
     *          'business' => $this->>getBusiness()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}