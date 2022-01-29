<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasStatusInterface;

/**
 * Trait to implement StatusTrait property.
 *
 * @see HasStatusInterface
 */
trait StatusTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="integer", options={ "default": 0 })
     */
    protected int $status;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return int int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  StatusTrait constructor.
     */
    public function __construct(int $status)
    {
        $this->setStatus($status);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'status' => $this->getStatus(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}