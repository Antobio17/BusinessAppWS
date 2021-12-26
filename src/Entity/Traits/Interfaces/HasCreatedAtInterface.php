<?php

namespace App\Entity\Traits\Interfaces;

use App\Entity\Traits\CreatedAtTrait;
use DateTime;

/**
 * CreatedAt property that indicates the moment when the object was created.
 */
interface HasCreatedAtInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the CreatedAt property.
     *
     * @return DateTime DateTime
     */
    public function getCreatedAt(): DateTime;

    /**
     * Sets the CreatedAt property.
     *
     * @param DateTime $createdAt The creation date to be set.
     *
     * @return $this $this
     */
    public function setCreatedAt(DateTime $createdAt): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     * Returns array(
     *      'createdAt' => $this->>getCreatedAt
     * )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}