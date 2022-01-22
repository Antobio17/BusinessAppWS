<?php

namespace App\Service\Interfaces;

use App\Entity\AppError;
use TelegramBot\Api\BotApi;

/**
 * TelegramService interface.
 */
interface TelegramServiceInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the BotApi property.
     *
     * @return BotApi BotApi
     */
    public function getBot(): BotApi;

    /**
     * Sets the Bot property.
     *
     * @param string $TOKEN The token to initialize de Telegram Bot.
     *
     * @return $this $this
     */
    public function setBot(string $TOKEN): self;

    /**
     * Sets the ChatID property.
     *
     * @param string $chatID The ChatID where the message will be sent.
     *
     * @return $this $this
     */
    public function setChatID(string $chatID): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Method to notify by the Telegram Bot.
     *
     * @param AppError $error AppError to send.
     *
     * @return bool bool
     */
    public function sendNotificationAppError(AppError $error): bool;

    /**
     * Method to notify by the Telegram Bot.
     *
     * @param string $message Message to send.
     *
     * @return bool bool
     */
    public function sendNotification(string $message): bool;

    /*********************************************** STATIC METHODS ***********************************************/

}