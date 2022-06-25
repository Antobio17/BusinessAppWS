<?php

namespace App\Entity\Interfaces;

use App\Entity\Product;
use App\Entity\Traits\Interfaces\HasCodeInterface;
use App\Entity\Traits\Interfaces\HasNameInterface;

/**
 * Product interface.
 */
interface ProductInterface extends HasNameInterface, HasCodeInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Price property of the Entity.
     *
     * @return float float
     */
    public function getPrice(): float;

    /**
     * Sets the Price property of the Entity.
     *
     * @param float $price Price of the entity.
     *
     * @return Product Product
     */
    public function setPrice(float $price): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}