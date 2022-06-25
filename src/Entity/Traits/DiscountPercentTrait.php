<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasDiscountPercentInterface;

/**
 * Trait to implement DiscountPercentTrait property.
 *
 * @see HasDiscountPercentInterface
 */
trait DiscountPercentTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="integer", options={ "default": 0 })
     */
    protected int $discountPercent;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return int int
     */
    public function getDiscountPercent(): int
    {
        return $this->discountPercent;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setDiscountPercent(int $discountPercent): self
    {
        $this->discountPercent = $discountPercent;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  DiscountPercentTrait constructor.
     */
    public function __construct(int $discountPercent = 0)
    {
        $this->setDiscountPercent($discountPercent);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'discountPercent' => $this->getDiscountPercent(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}