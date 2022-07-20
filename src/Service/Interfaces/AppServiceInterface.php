<?php

namespace App\Service\Interfaces;

use App\Entity\AbstractORM;
use App\Entity\Interfaces\ORMInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Interfaces\AppErrorInterface;
use App\Service\Traits\Interfaces\HasBusinessInterface;
use App\Service\Traits\Interfaces\HasRepositoriesInterface;

interface AppServiceInterface extends HasRepositoriesInterface, HasBusinessInterface
{

    /************************************************** ROUTING ***************************************************/

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Test Mode property.
     *
     * @return bool bool
     */
    public function getTestMode(): bool;

    /**
     * Sets the Test Mode property.
     *
     * @param bool $testMode The value of test mode to set.
     *
     * @return $this $this
     */
    public function setTestMode(bool $testMode): self;

    /**
     * Gets the Entity Manager property.
     *
     * @return ObjectManager ObjectManager
     */
    public function getEntityManager(): ObjectManager;

    /**
     * Sets the Entity Manager property.
     *
     * @param ObjectManager $entityManager The entity manager to set.
     *
     * @return $this $this
     */
    public function setEntityManager(ObjectManager $entityManager): self;

    /**
     * Gets the TelegramService property.
     *
     * @return TelegramServiceInterface TelegramServiceInterface
     */
    public function getTelegramService(): TelegramServiceInterface;

    /**
     * Sets the TelegramService property.
     *
     * @param TelegramServiceInterface $telegramService The TelegramService to set.
     *
     * @return $this $this
     */
    public function setTelegramService(TelegramServiceInterface $telegramService): self;

    /**
     * Gets the error's array of the AppService.
     *
     * @return array array
     */
    public function getErrors(): array;

    /**
     * Sets the error's array of the AppService.
     *
     * @param array $errors The errors to set.
     *
     * @return $this $this
     */
    public function setErrors(array $errors = array()): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Sets the business context of the operations.
     *
     * @param string|null $domain Domain to identify the business.
     *
     * @return bool bool
     */
    public function setBusinessContext(?string $domain): bool;

    /**
     * Persists an ORM object.
     *
     * @param AbstractORM $object Object to persist in the app.
     *
     * @return bool bool
     */
    public function persistAndFlush(ORMInterface $object): bool;

    /**
     * Logs an error when trying to persist an ORM object.
     *
     * @param string $method Method where the error occurred.
     * @param int $exceptionCode Code of the exception catch.
     * @param string $exceptionMessage Message of the exception catch.
     * @param array $exceptionTrace Trace of the exception catch.
     *
     * @return AppErrorInterface AppErrorInterface
     */
    public function registerPersistException(string $method, int $exceptionCode, string $exceptionMessage,
                                             array  $exceptionTrace): AppErrorInterface;

    /**
     * Logs an error.
     *
     * @param string $method Method where the error occurred.
     * @param int $type Type of the AppError.
     * @param string $message Message of the AppError.
     * @param int|null $exceptionCode Code of the exception catch.
     * @param string|null $exceptionMessage Message of the exception catch.
     * @param array $exceptionTrace Trace of the exception catch.
     * @param bool $notify Boolean to notify or not the error.
     * @param bool $persist Boolean to persist or not the error.
     *
     * @return AppErrorInterface AppErrorInterface
     */
    public function registerAppError(string  $method, int $type, string $message, ?int $exceptionCode = NULL,
                                     ?string $exceptionMessage = NULL, array $exceptionTrace = array(),
                                     bool    $notify = TRUE, bool $persist = TRUE): AppErrorInterface;

    /**
     * Logs an error when the context of the business is not set.
     *
     * @param string $method Method where the error occurred.
     *
     * @return AppErrorInterface AppErrorInterface
     */
    public function registerAppError_BusinessContextUndefined(string $method): AppErrorInterface;

    /**
     * Logs an error when the context of the user is not set.
     *
     * @param string $method Method where the error occurred.
     *
     * @return AppErrorInterface AppErrorInterface
     */
    public function registerAppError_UserContextUndefined(string $method): AppErrorInterface;

    /*********************************************** STATIC METHODS ***********************************************/

}