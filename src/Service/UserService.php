<?php

namespace App\Service;

use App\Entity\AppError;
use App\Entity\User;
use App\Helper\ToolsHelper;
use App\Service\Interfaces\UserServiceInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService extends AppService implements UserServiceInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var UserPasswordHasherInterface
     */
    protected UserPasswordHasherInterface $userPasswordHasher;

    /************************************************* CONSTRUCT **************************************************/

    /**
     * AppService construct.
     *
     * @param ManagerRegistry $doctrine Doctrine to manage the ORM.
     * @param TelegramService $telegramService Service of Telegram.
     * @param bool $testMode Boolean to set the Test Mode.
     * @param UserPasswordHasherInterface $userPasswordHasher Hasher to encode the user password.
     *
     */
    public function __construct(ManagerRegistry $doctrine, TelegramService $telegramService,
        UserPasswordHasherInterface $userPasswordHasher, bool $testMode = FALSE)
    {
        parent::__construct($doctrine, $telegramService, $testMode);

        $this->setUserPasswordHasher($userPasswordHasher);
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

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return bool bool
     * @noinspection PhpDocMissingThrowsInspection
     * @noinspection PhpUnhandledExceptionInspection
     */
    public function signup(string $email, string $password, string $phoneNumber, string $name, string $surname): bool
    {
        $user = $this->getUserRepository()->findByEmail($email);

        if ($user === NULL):
            $user = new User($email, $password, $phoneNumber, $name, $surname);
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

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}