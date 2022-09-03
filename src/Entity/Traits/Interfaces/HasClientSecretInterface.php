<?php

namespace App\Entity\Traits\Interfaces;

/**
 * ClientSecretTrait interface
 */
interface HasClientSecretInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the ClientSecret property of the Entity.
     *
     * @return string|null string|null
     */
    public function getClientSecret(): ?string;

    /**
     * Sets the ClientSecret property of the Entity.
     *
     * @param string|null $clientSecret ClientSecret of the Entity to set.
     *
     * @return $this $this
     */
    public function setClientSecret(?string $clientSecret): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'clientSecret' => $this->getClientSecret()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}