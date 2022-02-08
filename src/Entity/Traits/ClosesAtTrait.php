<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasClosesAtInterface;

/**
 * Trait to implement ClosesAt property.
 *
 * @see HasClosesAtInterface
 */
trait ClosesAtTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="string", nullable=false, options={"default": "20:00:00"})
     */
    protected string $closesAt;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getClosesAt(): string
    {
        return $this->closesAt;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setClosesAt(string $closesAt): self
    {
        $this->closesAt = $closesAt;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  ClosesAtTrait constructor.
     */
    public function __construct(string $closesAt)
    {
        $this->setClosesAt($closesAt);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'closesAt' => $this->getClosesAt()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}