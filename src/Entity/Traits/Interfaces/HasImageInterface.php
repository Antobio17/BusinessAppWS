<?php

namespace App\Entity\Traits\Interfaces;

/**
 * Image interface.
 */
interface HasImageInterface extends HasNameInterface, HasWidthInterface, HasHeightInterface, HasAltInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the entity.
     *
     *      Returns array(
     *          'homeConfigID' => $this->>getHomeConfig()->getID()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /**
     * ToString function of the entity.
     *
     * @return string string
     */
    public function __toString(): string;

    /*********************************************** STATIC METHODS ***********************************************/

}