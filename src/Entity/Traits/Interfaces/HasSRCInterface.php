<?php

namespace App\Entity\Traits\Interfaces;

/**
 * SRCTrait interface
 */
interface HasSRCInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the SRC property of the Entity.
     *
     * @return string string
     */
    public function getSRC(): string;

    /**
     * Sets the SRC property of the Entity.
     *
     * @param string $src SRC of the Entity to set.
     *
     * @return $this $this
     */
    public function setSRC(string $src): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'src' => $this->getSRC()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}