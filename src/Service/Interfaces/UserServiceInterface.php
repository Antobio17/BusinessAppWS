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

    /**
     * Registers a new user in the application.
     *
     * @param string $email The email of the new user.
     * @param string $password The password of the new user.
     * @param string $phoneNumber The phone number of the new user.
     * @param string $name The name of the new user.
     * @param string $surname The surname of the new user.
     *
     * @return bool bool
     */
    public function signup(string $email, string $password, string $phoneNumber, string $name, string $surname): bool;

    /*********************************************** STATIC METHODS ***********************************************/

}