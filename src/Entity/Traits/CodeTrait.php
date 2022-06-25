<?php

namespace App\Entity\Traits;

use App\Helper\ToolsHelper;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasCodeInterface;

/**
 * Trait to implement Code property.
 *
 * @see HasCodeInterface
 */
trait CodeTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="string", length=1024, nullable=false)
     */
    protected string $code;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  CodeTrait constructor.
     *
     * @param string $code Code of the Entity to set.
     */
    public function __construct(string $code)
    {
        $this->setCode($code);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'code' => $this->getCode()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}