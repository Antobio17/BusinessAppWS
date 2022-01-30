<?php

namespace App\Service\Traits\Interfaces;

use App\Service\Interfaces\UserServiceInterface;

/**
 * UserServiceTrait interface.
 */
interface HasUserServiceInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the property UserService.
     *
     * @return UserServiceInterface UserServiceInterface
     */
    public function getUserService(): UserServiceInterface;

    /**
     * Sets the property UserService.
     *
     * @param UserServiceInterface $userService The service of user to set.
     *
     * @return $this $this
     */
    public function setUserService(UserServiceInterface $userService): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}