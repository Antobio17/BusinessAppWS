<?php

namespace App\Entity\Traits;

use App\Helper\ToolsHelper;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasUUIDInterface;

/**
 * Trait to implement UUID property.
 *
 * @see HasUUIDInterface
 */
trait UUIDTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="string", length=1024, unique=true)
     */
    protected string $uuid;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getUUID(): string
    {
        return $this->uuid;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setUUID(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  UUIDTrait constructor.
     *
     * @param string $uuid UUID of the Entity to set.
     */
    public function __construct(string $uuid)
    {
        $this->setUUID($uuid);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'uuid' => $this->getUUID()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}