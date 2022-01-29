<?php

namespace App\Entity\Traits;

use App\Helper\ToolsHelper;
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
     * @ORM\Column(type="string", length=1024)
     */
    protected string $postalCode;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getPostalCode(): string
    {
        return ToolsHelper::decrypt($this->postalCode, getenv(static::SECRET_ENCRYPTION_TOKEN));
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = ToolsHelper::encrypt($postalCode, getenv(static::SECRET_ENCRYPTION_TOKEN));

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