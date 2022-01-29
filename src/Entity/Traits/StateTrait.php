<?php

namespace App\Entity\Traits;

use App\Helper\ToolsHelper;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasStateInterface;

/**
 * Trait to implement StateTrait property.
 *
 * @see HasStateInterface
 */
trait StateTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="string", length=1024)
     */
    protected string $state;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getState(): string
    {
        return ToolsHelper::decrypt($this->state, getenv(static::SECRET_ENCRYPTION_TOKEN));
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setState(string $state): self
    {
        $this->state = ToolsHelper::encrypt($state, getenv(static::SECRET_ENCRYPTION_TOKEN));

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  StateTrait constructor.
     *
     * @param string $state State to set in the entity.
     */
    public function __construct(string $state)
    {
        $this->setState($state);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'state' => $this->getState()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}