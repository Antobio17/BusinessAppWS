<?php

namespace App\Service;

use App\Entity\AppError;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Exception as TelegramException;
use App\Service\Interfaces\TelegramServiceInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Telegram service.
 */
class TelegramService implements TelegramServiceInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var BotApi
     */
    protected BotApi $bot;

    /**
     * @var string
     */
    protected string $chatID;

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  TelegramService constructor.
     */
    public function __construct(ParameterBagInterface $parameterBag)
    {
        /** @noinspection MissingService */
        $this->setBot($parameterBag->get('app.telegram_bot_api_token'))
            ->setChatID($parameterBag->get('app.telegram_chat_id_developer'));
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return BotApi BotApi
     */
    public function getBot(): BotApi
    {
        return $this->bot;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setBot(string $TOKEN): self
    {
        $this->bot = new BotApi($TOKEN);

        return $this;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setChatID(string $chatID): self
    {
        $this->chatID = $chatID;

        return $this;
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return bool bool
     */
    public function sendNotificationAppError(AppError $error): bool
    {
        $message = $this->_formatAppErrorToHTML($error);

        return $this->sendNotification($message);
    }

    /**
     * @inheritDoc
     * @return bool bool
     */
    public function sendNotification(string $message): bool
    {
        try {
            $this->getBot()->sendMessage($this->chatID, $message, 'HTML');
            $sent = TRUE;
        } catch (TelegramException $e) {
            $sent = FALSE;
        }

        return $sent;
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /**
     * Method to format the AppError to HTML.
     *
     * @param AppError $error The AppError to format.
     *
     * @return string string
     */
    protected function _formatAppErrorToHTML(AppError $error): string
    {
        $message = '<b>' . $error->getCreatedAt()->format('d/m/Y h:i:s') . '</b>' . chr(10) .
            '<b>' . $error->getMethod() . '</b>' . chr(10) . chr(10) .
            $error->getMessage();

        if ($error->getExceptionCode() !== NULL):
            $message .= chr(10) . chr(10) . '<b>Excepción</b>' . chr(10) .
                '<b>Código: </b>' . $error->getExceptionCode() . chr(10) .
                '<b>Mensaje: </b>' . $error->getExceptionMessage() . chr(10);

        endif;

        return $message;
    }

    /*********************************************** STATIC METHODS ***********************************************/

}