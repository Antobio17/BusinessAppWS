<?php

namespace App\Entity\Interfaces;

use App\Entity\Traits\Interfaces\HasImageInterface;

/**
 * SocialImage interface.
 */
interface SocialImageInterface extends HasImageInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Business property.
     *
     * @return HomeConfigInterface HomeConfigInterface
     */
    public function getHomeConfig(): HomeConfigInterface;

    /**
     * Sets the Business property.
     *
     * @param HomeConfigInterface $homeConfig The HomeConfig to be set.
     *
     * @return $this $this
     */
    public function setHomeConfig(HomeConfigInterface $homeConfig): self;

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