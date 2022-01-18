<?php

namespace App\Entity\Traits\Interfaces;

use App\Entity\Traits\TypeTrait;

/**
 * TypeTrait interface
 */
interface HasTypeInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Type property.
     *
     * @return int int
     */
    public function getType(): int;

    /**
     * Sets the Type property.
     *
     * @param int $type The type to be set.
     *
     * @return $this $this
     */
    public function setType(int $type): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'type' => $this->>getType()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}