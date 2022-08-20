<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasWidthInterface;

/**
 * Trait to implement WidthTrait property.
 *
 * @see HasWidthInterface
 */
trait WidthTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="integer", options={ "default": 0 })
     */
    protected int $width;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return int int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  WidthTrait constructor.
     */
    public function __construct(int $width = 0)
    {
        $this->setWidth($width);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'width' => $this->getWidth(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}