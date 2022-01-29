<?php

namespace App\Entity\Traits;

use App\Entity\PostalAddress;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use App\Entity\Traits\Interfaces\HasPostalAddressInterface;

/**
 * Trait to implement PostalAddress property.
 *
 * @see HasPostalAddressInterface
 */
trait PostalAddressTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ManyToOne(targetEntity="App\Entity\PostalAddress", cascade={"persist"})
     * @JoinColumn(name="postalAddress_id", referencedColumnName="id", nullable=true)
     */
    protected ?PostalAddress $postalAddress;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return PostalAddress|null PostalAddress|null
     */
    public function getPostalAddress(): ?PostalAddress
    {
        return $this->postalAddress;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setPostalAddress(PostalAddress $postalAddress): self
    {
        $this->postalAddress = $postalAddress;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  PostalAddressTrait constructor.
     *
     * @param PostalAddress $postalAddress PostalAddress of the Entity to set.
     */
    public function __construct(PostalAddress $postalAddress)
    {
        $this->setPostalAddress($postalAddress);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'postalAddress' => $this->getPostalAddress() !== NULL ? $this->getPostalAddress()->__toArray() : NULL
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}