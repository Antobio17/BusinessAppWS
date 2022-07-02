<?php

namespace App\Entity\Interfaces;

use App\Entity\Product;
use App\Entity\Traits\Interfaces\HasAmountInterface;
use App\Entity\Traits\Interfaces\HasCategoryInterface;
use App\Entity\Traits\Interfaces\HasCodeInterface;
use App\Entity\Traits\Interfaces\HasDescriptionInterface;
use App\Entity\Traits\Interfaces\HasDiscountPercentInterface;
use App\Entity\Traits\Interfaces\HasNameInterface;
use App\Entity\Traits\Interfaces\HasSRCInterface;
use App\Entity\Traits\Interfaces\HasStockInterface;

/**
 * Product interface.
 */
interface ProductInterface extends HasNameInterface, HasCodeInterface, HasDescriptionInterface, HasAmountInterface,
    HasStockInterface, HasCategoryInterface, HasDiscountPercentInterface, HasSRCInterface
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