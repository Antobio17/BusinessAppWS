<?php

namespace App\Entity\Traits\Interfaces;

use App\Entity\Image;

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
    public function getSocialImages(): array;

    /**
     * Add an image to property collection of the Entity.
     *
     * @param Image $socialImage The image to set.
     *
     * @return $this $this
     */
    public function addSocialImage(Image $socialImage): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Gets the social images as an array.
     *
     * @return array array
     */
    public function getSocialImagesAsArray(): array;

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