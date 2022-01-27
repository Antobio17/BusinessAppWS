<?php

namespace App\Service;

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
     * @param string $email
     * @param string $password
     * @param string $phoneNumber
     * @param string $name
     * @param string $surname
     *
     * @return bool bool
     */
    public function signup(string $email, string $password, string $phoneNumber, string $name, string $surname): bool
    {
        return FALSE;
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}