<?php

namespace App\Entity\Traits;

use App\Entity\PostalAddress;
use Doctrine\ORM\Mapping\OneToMany;
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
     * @OneToMany(targetEntity="PostalAddress", cascade={"persist", "remove"})
     */
    private PostalAddress $postalAddress;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return PostalAddress PostalAddress
     */
    public function getPostalAddress(): PostalAddress
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
            'postalAddress' => $this->getPostalAddress()->__toArray()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}