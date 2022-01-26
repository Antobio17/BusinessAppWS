<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasPostalCodeInterface;

/**
 * Trait to implement PostalCodeTrait property.
 *
 * @see HasPostalCodeInterface
 */
trait PostalCodeTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="string", length=20)
     */
    private string $postalCode;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  PostalCodeTrait constructor.
     *
     * @param string $postalCode PostalCode to set in the entity.
     */
    public function __construct(string $postalCode)
    {
        $this->setPostalCode($postalCode);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'postalCode' => $this->getPostalCode()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}