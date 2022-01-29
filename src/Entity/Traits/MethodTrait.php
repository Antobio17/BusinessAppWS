<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasMethodInterface;

/**
 * Trait to implement Method property.
 *
 * @see HasMethodInterface
 */
trait MethodTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var string
     * @ORM\Column(type="string", length=512)
     */
    protected string $method;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  MethodTrait constructor.
     */
    public function __construct(string $method)
    {
        $this->setMethod($method);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'method' => $this->getMethod(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}