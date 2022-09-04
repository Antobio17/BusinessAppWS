<?php

namespace App\Entity\Traits\Interfaces;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * IsVerifiedTrait interface
 */
interface HasIsVerifiedInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the IsVerified property.
     *
     * @return bool bool
     */
    public function getIsVerified(): bool;

    /**
     * Sets the IsVerified property.
     *
     * @param bool $isVerified The IsVerified to be set.
     *
     * @return $this $this
     */
    public function setIsVerified(bool $isVerified): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'isVerified' => $this->>getIsVerified()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}