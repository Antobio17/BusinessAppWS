<?php

namespace App\Entity\Traits\Interfaces;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * UserTrait interface
 */
interface HasUserInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the User property.
     *
     * @return UserInterface UserInterface
     */
    public function getUser(): UserInterface;

    /**
     * Sets the User property.
     *
     * @param UserInterface $user The User to be set.
     *
     * @return $this $this
     */
    public function setUser(UserInterface $user): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'user' => $this->>getUser()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}