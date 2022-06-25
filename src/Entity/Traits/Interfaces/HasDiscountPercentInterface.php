<?php

namespace App\Entity\Traits\Interfaces;

/**
 * DiscountPercentTrait interface
 */
interface HasDiscountPercentInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the DiscountPercent property.
     *
     * @return int int
     */
    public function getDiscountPercent(): int;

    /**
     * Sets the DiscountPercent property.
     *
     * @param int $discountPercent The DiscountPercent to be set.
     *
     * @return $this $this
     */
    public function setDiscountPercent(int $discountPercent): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'discountPercent' => $this->>getDiscountPercent()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}