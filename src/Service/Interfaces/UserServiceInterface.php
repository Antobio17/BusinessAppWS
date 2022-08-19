<?php

namespace App\Service\Interfaces;


use App\Service\UserService;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
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

    /**
     * Gets the AuthenticationSuccessHandler to return a response with the user's token.
     *
     * @return AuthenticationSuccessHandler AuthenticationSuccessHandler
     */
    public function getAuthenticationSuccessHandler(): AuthenticationSuccessHandler;

    /**
     * Sets the AuthenticationSuccessHandler to return a response with the user's token.
     *
     * @param AuthenticationSuccessHandler $authenticationSuccessHandler Handler to return a response with user's token.
     *
     * @return $this $this
     */
    public function setAuthenticationSuccessHandler(AuthenticationSuccessHandler $authenticationSuccessHandler): self;

    /**
     * Gets the PasswordHasherFactoryInterface to check the user logging.
     *
     * @return PasswordHasherFactoryInterface PasswordHasherFactoryInterface
     */
    public function getPasswordHasherFactoryInterface(): PasswordHasherFactoryInterface;

    /**
     * Sets the PasswordHasherFactoryInterface to check the user logging.
     *
     * @param PasswordHasherFactoryInterface $passwordHasherFactory Factory of PasswordHasher.
     *
     * @return $this $this
     */
    public function setPasswordHasherFactoryInterface(PasswordHasherFactoryInterface $passwordHasherFactory): self;

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

    /**
     * Checks if the logging of the user is correct.
     *
     *      return (
     *          'token' => 'the token'
     *      )
     *
     * @param string $email The email of the new user.
     * @param string $password The password of the new user.
     *
     * @return array|null array|null
     */
    public function signin(string $email, string $password): ?array;

    /**
     * Manage a postal address to the user logged, if an ID is passed it will modify the existing address.
     *
     * @param string $name Name of the Postal Address.
     * @param string $address The address.
     * @param string|null $neighborhood The neighborhood of the postal address.
     * @param string $postalCode The postal code of the postal address.
     * @param string $population The population of the postal address.
     * @param string $province The province of the postal address.
     * @param string $state The state of the postal address.
     * @param int|null $postalAddressID The ID of an existing postal address.
     *
     * @return bool bool
     */
    public function managePostalAddress(string $name, string $address, ?string $neighborhood, string $postalCode,
                                        string $population, string $province, string $state,
                                        ?int $postalAddressID = NULL): bool;

    /**
     * Delete the postal address referenced by the ID to the user logged.
     *
     * @param int|null $postalAddressID The ID of an existing postal address.
     *
     * @return bool bool
     */
    public function deletePostalAddress(int $postalAddressID): bool;

    /**
     * Gets the data of the user logged.
     *
     *      return array(
     *          'id' => $user->getID(),
     *          'email' => $user->getEmail(),
     *          'name' => $user->getName(),
     *          'surname' => $user->getSurname(),
     *          'phoneNumber' => $user->getPhoneNumber()
     *      )
     *
     * @return array array
     */
    public function getUserData(): ?array;

    /**
     * Updates the sata of the user logged.
     *
     * @param string $email The email to set to the user.
     * @param string $phoneNumber The phone number to set to the user.
     * @param string $name The name to set to the user.
     * @param string $surname The surname to set to the user.
     * @param string|null $password The password to set to the user.
     *
     * @return bool bool
     */
    public function updateUserData(string  $email, string $phoneNumber, string $name, string $surname,
                                   ?string $password = NULL): bool;

    /*********************************************** STATIC METHODS ***********************************************/

}