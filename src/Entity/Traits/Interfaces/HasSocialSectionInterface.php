<?php

namespace App\Entity\Traits\Interfaces;

use App\Entity\SocialImage;
use Doctrine\Common\Collections\Collection;

/**
 * SocialSectionTrait interface
 */
interface HasSocialSectionInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the SocialData property of the Entity.
     *
     * @return SocialImage[]|Collection SocialImage[]|Collection
     */
    public function getSocialImages(): Collection;

    /**
     * Add an image to property collection of the Entity.
     *
     * @param SocialImage $socialImage The image to set.
     *
     * @return $this $this
     */
    public function addSocialImage(SocialImage $socialImage): self;

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