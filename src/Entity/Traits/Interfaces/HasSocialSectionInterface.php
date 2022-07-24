<?php

namespace App\Entity\Traits\Interfaces;

/**
 * SocialSectionTrait interface
 */
interface HasSocialSectionInterface extends HasDataInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the SocialData property of the Entity.
     *
     * @return array array
     */
    public function getSocialData(): array;

    /**
     * Sets the SocialData property of the Entity.
     *
     * @param array $socialData The data to set.
     *
     * @return $this $this
     */
    public function setSocialData(array $socialData): self;

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