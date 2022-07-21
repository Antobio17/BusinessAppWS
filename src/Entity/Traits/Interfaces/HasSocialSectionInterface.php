<?php

namespace App\Entity\Traits\Interfaces;

/**
 * SocialSectionTrait interface
 */
interface HasSocialSectionInterface extends HasDataInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/



    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          $this->__dataToArray()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}