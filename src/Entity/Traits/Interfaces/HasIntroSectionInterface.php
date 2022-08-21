<?php

namespace App\Entity\Traits\Interfaces;

use App\Entity\Image;

/**
 * IntroSectionTrait interface
 */
interface HasIntroSectionInterface extends HasNameInterface, HasDescriptionInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the property Image of the entity.
     *
     * @return Image Image
     */
    public function getImage(): Image;

    /**
     * Sets the property Image of the entity.
     *
     * @param Image $image The image to set.
     *
     * @return $this $this
     */
    public function setImage(Image $image): self;

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