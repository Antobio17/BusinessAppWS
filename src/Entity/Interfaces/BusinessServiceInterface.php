<?php

namespace App\Entity\Interfaces;

use App\Entity\Image;

/**
 * BusinessService interface.
 */
interface BusinessServiceInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the HomeConfig property.
     *
     * @return HomeConfigInterface HomeConfigInterface
     */
    public function getHomeConfig(): HomeConfigInterface;

    /**
     * Sets the HomeConfig property.
     *
     * @param HomeConfigInterface $homeConfig The HomeConfig to be set.
     *
     * @return $this $this
     */
    public function setHomeConfig(HomeConfigInterface $homeConfig): self;

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

    /**
     * Gets the Title property.
     *
     * @return string string
     */
    public function getTitle(): string;

    /**
     * Sets the Title property.
     *
     * @param string $title The title to be set.
     *
     * @return $this $this
     */
    public function setTitle(string $title): self;

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

    /*********************************************** STATIC METHODS ***********************************************/

}