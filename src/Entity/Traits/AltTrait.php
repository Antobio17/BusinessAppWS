<?php

namespace App\Entity\Traits;

use App\Helper\ToolsHelper;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasAltInterface;

/**
 * Trait to implement Alt property.
 *
 * @see HasAltInterface
 */
trait AltTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="string", length=1024)
     */
    protected string $alt;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getAlt(): string
    {
        return $this->alt;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setAlt(string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  AltTrait constructor.
     *
     * @param string $alt Alt of the Entity to set.
     */
    public function __construct(string $alt)
    {
        $this->setAlt($alt);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'alt' => $this->getAlt()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}