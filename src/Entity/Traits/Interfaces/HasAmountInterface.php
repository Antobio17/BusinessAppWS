<?php

namespace App\Entity\Traits\Interfaces;

/**
 * AmountTrait interface
 */
interface HasAmountInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Amount property.
     *
     * @return float float
     */
    public function getAmount(): float;

    /**
     * Sets the Amount property.
     *
     * @param float $amount The Amount to be set.
     *
     * @return $this $this
     */
    public function setAmount(float $amount): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'amount' => $this->>getAmount()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}