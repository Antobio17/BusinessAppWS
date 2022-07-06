<?php

namespace App\Service;

use App\Entity\AbstractBusinessContext;
use App\Entity\AppError;
use App\Entity\PostalAddress;
use App\Entity\User;
use App\Helper\ToolsHelper;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use App\Service\Interfaces\UserServiceInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;

class UserService extends AppService implements UserServiceInterface
{

    /************************************************* CONSTANTS **************************************************/

    public const MAX_POSTAL_ADDRESSES = 5;

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var UserPasswordHasherInterface
     */
    protected UserPasswordHasherInterface $userPasswordHasher;

    /**
     * @var AuthenticationSuccessHandler
     */
    protected AuthenticationSuccessHandler $authenticationSuccessHandler;

    protected PasswordHasherFactoryInterface $passwordHasherFactory;

    /************************************************* CONSTRUCT **************************************************/

    /**
     * UserService construct.
     *
     * @param ManagerRegistry $doctrine Doctrine to manage the ORM.
     * @param TelegramService $telegramService Service of Telegram.
     * @param UserPasswordHasherInterface $userPasswordHasher Hasher to encode the user password.
     * @param AuthenticationSuccessHandler $authenticationSuccessHandler Handler to return a response with user's token.
     * @param PasswordHasherFactoryInterface $passwordHasherFactory The Factory PasswordHasher.
     * @param bool $testMode Boolean to set the Test Mode.
     */
    public function __construct(ManagerRegistry                $doctrine, TelegramService $telegramService,
                                UserPasswordHasherInterface    $userPasswordHasher,
                                AuthenticationSuccessHandler   $authenticationSuccessHandler,
                                PasswordHasherFactoryInterface $passwordHasherFactory, bool $testMode = FALSE)
    {
        parent::__construct($doctrine, $telegramService, $testMode);

        $this->setUserPasswordHasher($userPasswordHasher);
        $this->setAuthenticationSuccessHandler($authenticationSuccessHandler);
        $this->setPasswordHasherFactoryInterface($passwordHasherFactory);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return UserPasswordHasherInterface UserPasswordHasherInterface
     */
    public function getUserPasswordHasher(): UserPasswordHasherInterface
    {
        return $this->userPasswordHasher;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setUserPasswordHasher(UserPasswordHasherInterface $userPasswordHasher): self
    {
        $this->userPasswordHasher = $userPasswordHasher;

        return $this;
    }

    /**
     * @inheritDoc
     * @return AuthenticationSuccessHandler AuthenticationSuccessHandler
     */
    public function getAuthenticationSuccessHandler(): AuthenticationSuccessHandler
    {
        return $this->authenticationSuccessHandler;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setAuthenticationSuccessHandler(AuthenticationSuccessHandler $authenticationSuccessHandler): self
    {
        $this->authenticationSuccessHandler = $authenticationSuccessHandler;

        return $this;
    }

    /**
     * @inheritDoc
     * @return PasswordHasherFactoryInterface PasswordHasherFactoryInterface
     */
    public function getPasswordHasherFactoryInterface(): PasswordHasherFactoryInterface
    {
        return $this->passwordHasherFactory;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setPasswordHasherFactoryInterface(PasswordHasherFactoryInterface $passwordHasherFactory): self
    {
        $this->passwordHasherFactory = $passwordHasherFactory;

        return $this;
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return bool bool
     */
    public function signup(string $email, string $password, string $phoneNumber, string $name, string $surname): bool
    {
        $business = $this->getBusiness();
        $user = $this->getUserRepository()->findByEmail($business, $email);

        if ($user === NULL):
            $user = new User($business, $email, $password, $phoneNumber, $name, $surname);
            $encodedPassword = $this->getUserPasswordHasher()->hashPassword($user, $password);
            $user->setPassword($encodedPassword);
            $this->persistAndFlush($user);
        else:
            $this->registerAppError(
                ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__),
                Response::HTTP_CONFLICT,
                'El email introducido ya existe.',
                NULL, NULL, array(),
                FALSE, FALSE
            );
        endif;

        return empty($this->getErrors());
    }

    /**
     * @inheritDoc
     * @return array array
     */
    public function signin(string $email, string $password): ?array
    {
        $business = $this->getBusiness();
        $user = $this->getUserRepository()->findByEmail(
            $business, $email
        );

        $token = NULL;
        if ($user !== NULL):
            if ($this->passwordHasherFactory->getPasswordHasher($user)->verify($user->getPassword(), $password)):
                $JSONToken = $this->getAuthenticationSuccessHandler()->handleAuthenticationSuccess($user)->getContent();
                $token = json_decode($JSONToken, TRUE);
            endif;
        endif;

        if ($token === NULL):
            $this->registerAppError(
                ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__),
                Response::HTTP_UNAUTHORIZED,
                'El email o contraseña no son correctos.',
                NULL, NULL, array(),
                FALSE, FALSE
            );
        endif;

        return $token;
    }


    /**
     * @inheritDoc
     * @return bool bool
     */
    public function managePostalAddress(string $name, string $address, ?string $neighborhood, string $postalCode,
                                        string $population, string $province, string $state,
                                        ?int   $postalAddressID = NULL): bool
    {
        $user = $this->getUser();
        if ($user instanceof User):
            if ($postalAddressID !== NULL):
                $postalAddress = $user->isOwnerPostalAddress($postalAddressID);
                if ($postalAddress !== NULL):
                    $postalAddress->setName($name)
                        ->setAddress($address)
                        ->setNeighborhood($neighborhood)
                        ->setPostalCode($postalCode)
                        ->setPopulation($population)
                        ->setProvince($province)
                        ->setState($state);
                    $persisted = $this->persistAndFlush($postalAddress);
                else:
                    $this->registerAppError(
                        ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__),
                        AppError::ERROR_USER_WRONG_POSTAL_ADDRESS,
                        'Error en la actualización de dirección postal: no pertenece al usuario de la sesión.'
                    );
                endif;
            elseif ($user->getPostalAddresses()->count() < static::MAX_POSTAL_ADDRESSES):
                $postalAddress = new PostalAddress(
                    $name, $address, $neighborhood, $postalCode, $population, $province, $state
                );
                $user->addPostalAddress($postalAddress);
                $persisted = $this->persistAndFlush($user);
            endif;
        else:
            $this->registerAppError_UserContextUndefined(
                ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__)
            );
        endif;

        return $persisted ?? FALSE;
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}