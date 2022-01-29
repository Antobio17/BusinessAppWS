<?php

namespace App\Entity\Traits;

use App\Helper\ToolsHelper;
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
     * @ORM\Column(type="string", length=1024, unique=true)
     */
    protected string $phoneNumber;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getPhoneNumber(): string
    {
        return ToolsHelper::decrypt($this->phoneNumber, getenv(static::SECRET_ENCRYPTION_TOKEN));
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = ToolsHelper::encrypt($phoneNumber, getenv(static::SECRET_ENCRYPTION_TOKEN));

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