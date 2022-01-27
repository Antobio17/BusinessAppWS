<?php

namespace App\Service\Traits;

use App\Service\Interfaces\UserServiceInterface;
use App\Service\Traits\Interfaces\HasUserServiceInterface;

/**
 * Trait to implement User property.
 *
 * @see HasUserServiceInterface
 */
trait UserServiceTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var UserServiceInterface
     */
    protected UserServiceInterface $userService;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return UserServiceInterface UserServiceInterface
     */
    public function getUserService(): UserServiceInterface
    {
        return $this->userService;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setUserService(UserServiceInterface $userService): self
    {
        $this->userService = $userService;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}