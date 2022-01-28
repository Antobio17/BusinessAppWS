<?php

namespace App\Entity\Traits;

use App\Entity\Interfaces\BusinessInterface;
use App\Entity\Traits\Interfaces\HasBusinessInterface;

/**
 * Trait to implement BusinessTrait property.
 *
 * @see HasBusinessInterface
 */
trait BusinessTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     *
     */
    private ?BusinessInterface $business;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return BusinessInterface|null BusinessInterface|null
     */
    public function getBusiness(): ?BusinessInterface
    {
        return $this->business;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setBusiness(BusinessInterface $business): self
    {
        $this->business = $business;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  BusinessTrait constructor.
     */
    public function __construct(BusinessInterface $business)
    {
        $this->setBusiness($business);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'business' => $this->getBusiness()->__toArray(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}