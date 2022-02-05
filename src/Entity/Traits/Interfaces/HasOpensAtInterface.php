<?php

namespace App\Entity\Traits\Interfaces;

/**
 * OpensAtTrait interface
 */
interface HasOpensAtInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the OpensAt property.
     *
     * @return string string
     */
    public function getOpensAt(): string;

    /**
     * Sets the OpensAt property.
     *
     * @param string $opensAt The opens date to be set.
     *
     * @return $this $this
     */
    public function setOpensAt(string $opensAt): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'opensAt' => $this->getOpensAt()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}