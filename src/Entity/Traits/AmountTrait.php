<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasAmountInterface;

/**
 * Trait to implement AmountTrait property.
 *
 * @see HasAmountInterface
 */
trait AmountTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="float", options={ "default": 0.0 })
     */
    protected float $amount;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return float float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  AmountTrait constructor.
     */
    public function __construct(float $amount = 0)
    {
        $this->setAmount($amount);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'amount' => $this->getAmount(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}