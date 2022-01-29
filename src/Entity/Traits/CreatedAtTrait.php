<?php

namespace App\Entity\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasCreatedAtInterface;

/**
 * Trait to implement CreatedAt property.
 *
 * @see HasCreatedAtInterface
 */
trait CreatedAtTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    protected DateTime $createdAt;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return DateTime DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @inheritDoc
     * @param DateTime $createdAt
     * @return $this $this
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  CreatedAt constructor.
     */
    public function __construct(DateTime $createdAt)
    {
        $this->setCreatedAt($createdAt);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'createdAt' => $this->getCreatedAt(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}