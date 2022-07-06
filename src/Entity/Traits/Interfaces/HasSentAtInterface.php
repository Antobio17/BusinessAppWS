<?php

namespace App\Entity\Traits\Interfaces;

use App\Entity\Traits\SentAtTrait;
use DateTime;

/**
 * SentAt property that indicates the moment when the object was sent.
 */
interface HasSentAtInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the SentAt property.
     *
     * @return DateTime|null DateTime|null
     */
    public function getSentAt(): ?DateTime;

    /**
     * Sets the SentAt property.
     *
     * @param DateTime|null $sentAt The sent date to be set.
     *
     * @return $this $this
     */
    public function setSentAt(?DateTime $sentAt): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *              'sentAt' => $this->>getSentAt
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}