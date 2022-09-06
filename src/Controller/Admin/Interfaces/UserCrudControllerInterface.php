<?php

namespace App\Controller\Admin\Interfaces;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

interface UserCrudControllerInterface
{

    /************************************************** ROUTING ***************************************************/

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
     * Method to configure the CRUD of the entity. Its configure the labels of the User, the format of
     * fields and more.
     *
     * @param Crud $crud The CRUD to configure.
     *
     * @return Crud Crud
     */
    public function configureCrud(Crud $crud): Crud;

    /**
     * Methods to persist a new user.
     *
     * @param EntityManagerInterface $entityManager Entity manager.
     * @param $entityInstance $entityInstance Instance of the entity.
     */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void;

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * Method to get the entity FQCN of the Business. It returns the User::class.
     *
     * @return string string
     */
    public static function getEntityFqcn(): string;

}