<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasTypeInterface;

/**
 * Trait to implement TypeTrait property.
 *
 * @see HasTypeInterface
 */
trait TypeTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="integer", options={ "default": 0 })
     */
    private int $type;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return int int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  TypeTrait constructor.
     */
    public function __construct(int $type)
    {
        $this->setType($type);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'type' => $this->getType(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}