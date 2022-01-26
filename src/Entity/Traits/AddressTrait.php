<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasAddressInterface;

/**
 * Trait to implement AddressTrait property.
 *
 * @see HasAddressInterface
 */
trait AddressTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="string", length=512)
     */
    private string $address;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  AddressTrait constructor.
     *
     * @param string $address Address to set in the entity.
     */
    public function __construct(string $address)
    {
        $this->setAddress($address);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'address' => $this->getAddress()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}