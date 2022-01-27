<?php

namespace App\Service\Traits\Interfaces;

use App\Repository\UserRepository;
use App\Repository\Interfaces\AppErrorRepositoryInterface;
use App\Service\Interfaces\UserServiceInterface;
use App\Service\Traits\UserServiceTrait;

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