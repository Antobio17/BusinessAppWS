<?php

namespace App\Service\Interfaces;


use App\Service\UserService;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

interface UserServiceInterface extends AppServiceInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the UserPasswordHasher to encode the user password.
     *
     * @return UserPasswordHasherInterface UserPasswordHasherInterface
     */
    public function getUserPasswordHasher(): UserPasswordHasherInterface;

    /**
     * Sets the UserPasswordHasher to encode the user password.
     *
     * @param UserPasswordHasherInterface $userPasswordHasher Hasher to encode the user password.
     *
     * @return $this $this
     */
    public function setUserPasswordHasher(UserPasswordHasherInterface $userPasswordHasher): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}