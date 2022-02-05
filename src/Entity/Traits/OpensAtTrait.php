<?php

namespace App\Entity\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasOpensAtInterface;

/**
 * Trait to implement OpensAt property.
 *
 * @see HasOpensAtInterface
 */
trait OpensAtTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="string", nullable=false, options={"default": "09:00:00"})
     */
    protected string $opensAt;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getOpensAt(): string
    {
        return $this->opensAt;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setOpensAt(string $opensAt): self
    {
        $this->opensAt = $opensAt;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  OpensAtTrait constructor.
     *
     * @param string $opensAt
     */
    public function __construct(string $opensAt)
    {
        $this->setOpensAt($opensAt);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public
    function __toArray(): array
    {
        return array(
            'opensAt' => $this->getOpensAt()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}