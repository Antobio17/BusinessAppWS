<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasPhoneNumberInterface;

/**
 * Trait to implement PhoneNumber property.
 *
 * @see HasPhoneNumberInterface
 */
trait PhoneNumberTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="string", length=15, unique=true)
     */
    private string $phoneNumber;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  NameTrait constructor.
     *
     * @param string $phoneNumber PhoneNumber of the Entity to set.
     */
    public function __construct(string $phoneNumber)
    {
        $this->setPhoneNumber($phoneNumber);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'phoneNumber' => $this->getPhoneNumber()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}