<?php

namespace App\Entity\Traits;

use App\Entity\Interfaces\PostalAddressInterface;
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
     * @JoinColumn(name="postal_address_id", referencedColumnName="id", nullable=true)
     */
    protected ?PostalAddressInterface $postalAddress;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return PostalAddressInterface|null PostalAddressInterface|null
     */
    public function getPostalAddress(): ?PostalAddressInterface
    {
        return $this->postalAddress;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setPostalAddress(PostalAddressInterface $postalAddress): self
    {
        $this->postalAddress = $postalAddress;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  PostalAddressTrait constructor.
     *
     * @param PostalAddressInterface $postalAddress PostalAddress of the Entity to set.
     */
    public function __construct(PostalAddressInterface $postalAddress)
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