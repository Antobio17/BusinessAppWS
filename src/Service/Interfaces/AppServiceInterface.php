<?php

namespace App\Service\Interfaces;


use App\Entity\AppError;
use App\Entity\AbstractORM;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Interfaces\AbstractORMInterface;
use App\Service\Traits\Interfaces\HasRepositoriesInterface;

interface AppServiceInterface extends HasRepositoriesInterface
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

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Persists an ORM object.
     *
     * @param AbstractORM $object Object to persist in the app.
     *
     * @return bool bool
     */
    public function persistAndFlush(AbstractORMInterface $object): bool;

    /**
     * Logs an error when trying to persist an ORM object.
     *
     * @param string $method Method where the error occurred.
     * @param int $exceptionCode Code of the exception catch.
     * @param string $exceptionMessage Message of the exception catch.
     * @param array $exceptionTrace Trace of the exception catch.
     *
     * @return AppError AppError
     */
    public function registerPersistException(string $method, int $exceptionCode, string $exceptionMessage,
                                             array  $exceptionTrace): AppError;

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
     * @return AppError AppError
     */
    public function registerAppError(string  $method, int $type, string $message, ?int $exceptionCode = NULL,
                                     ?string $exceptionMessage = NULL, array $exceptionTrace = array(),
                                     bool    $notify = TRUE, bool $persist = TRUE): AppError;

    /*********************************************** STATIC METHODS ***********************************************/

}