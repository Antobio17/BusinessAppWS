<?php

namespace App\Service;

use App\Entity\AppError;
use App\Entity\User;
use App\Helper\ToolsHelper;
use App\Service\Interfaces\UserServiceInterface;
use Doctrine\Persistence\ManagerRegistry;

class UserService extends AppService implements UserServiceInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    /************************************************* CONSTRUCT **************************************************/

    /**
     * AppService construct.
     *
     * @param ManagerRegistry $doctrine Doctrine to manage the ORM.
     * @param TelegramService $telegramService Service of Telegram.
     * @param bool $testMode Boolean to set the Test Mode.
     */
    public function __construct(ManagerRegistry $doctrine, TelegramService $telegramService, bool $testMode = FALSE)
    {
        parent::__construct($doctrine, $telegramService, $testMode);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

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
     * @noinspection PhpDocMissingThrowsInspection
     * @noinspection PhpUnhandledExceptionInspection
     */
    public function signup(string $email, string $password, string $phoneNumber, string $name, string $surname): bool
    {
        $user = $this->getUserRepository()->findByEmail($email);

        if ($user === NULL):
            $user = new User($email, $password, $phoneNumber, $name, $surname);
            $this->persistAndFlush($user);
        else:
            $this->registerAppError(
                    ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__),
                    AppError::ERROR_BUSINESS_CONTEXT,
                    'El introducido email ya existe.',
                    NULL, NULL, array(),
                    FALSE, FALSE
            );
        endif;

        return empty($this->getErrors());
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}