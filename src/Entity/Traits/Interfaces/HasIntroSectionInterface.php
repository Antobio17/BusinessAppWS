<?php

namespace App\Entity\Traits\Interfaces;

/**
 * IntroSectionTrait interface
 */
interface HasIntroSectionInterface extends HasSRCInterface, HasNameInterface, HasDescriptionInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/



    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          $this->__nameToArray(),
     *          $this->__descriptionToArray(),
     *          $this->__srcToArray()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}