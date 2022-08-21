<?php

namespace App\Entity\Interfaces;

use App\Entity\Image;
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
    HasStockInterface, HasCategoryInterface, HasDiscountPercentInterface
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

    /**
     * Gets the property Image of the entity.
     *
     * @return Image Image
     */
    public function getImage(): Image;

    /**
     * Sets the property Image of the entity.
     *
     * @param Image $image The image to set.
     *
     * @return $this $this
     */
    public function setImage(Image $image): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}