<?php

namespace App\Entity\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasSentAtInterface;

/**
 * Trait to implement SentAt property.
 *
 * @see HasSentAtInterface
 */
trait SentAtTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    protected DateTime $sentAt;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return DateTime DateTime
     */
    public function getSentAt(): DateTime
    {
        return $this->sentAt;
    }

    /**
     * @inheritDoc
     * @param DateTime $sentAt
     * @return $this $this
     */
    public function setSentAt(DateTime $sentAt): self
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  SentAt constructor.
     */
    public function __construct(DateTime $sentAt)
    {
        $this->setSentAt($sentAt);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'sentAt' => $this->getSentAt(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}