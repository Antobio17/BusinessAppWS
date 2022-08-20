<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasHeightInterface;

/**
 * Trait to implement HeightTrait property.
 *
 * @see HasHeightInterface
 */
trait HeightTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="integer", options={ "default": 0 })
     */
    protected int $height;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return int int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  HeightTrait constructor.
     */
    public function __construct(int $height = 0)
    {
        $this->setHeight($height);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'height' => $this->getHeight(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}