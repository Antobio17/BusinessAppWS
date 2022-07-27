<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use App\Entity\Interfaces\BusinessInterface;
use App\Entity\Traits\Interfaces\HasBusinessNullableInterface;

/**
 * Trait to implement BusinessNullableTrait property.
 *
 * @see HasBusinessNullableInterface
 */
trait BusinessNullableTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ManyToOne(targetEntity="App\Entity\Business")
     * @JoinColumn(name="business_id", referencedColumnName="id", nullable=true)
     */
    protected BusinessInterface $business;

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
    public function setBusiness(?BusinessInterface $business): self
    {
        $this->business = $business;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  BusinessTrait constructor.
     */
    public function __construct(?BusinessInterface $business)
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
            'business' => $this->getBusiness() !== NULL ? $this->getBusiness()->__toArray() : NULL,
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}