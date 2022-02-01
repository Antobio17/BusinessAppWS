<?php

namespace App\Service;

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
     * @noinspection PhpDocMissingThrowsInspection
     * @noinspection PhpUnhandledExceptionInspection
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
     * @noinspection PhpDocMissingThrowsInspection
     * @noinspection PhpUnhandledExceptionInspection
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

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}