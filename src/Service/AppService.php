<?php

namespace App\Service;

use Exception;
use App\Entity\AppError;
use App\Helper\ToolsHelper;
use App\Service\Traits\BusinessTrait;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Interfaces\ORMInterface;
use App\Service\Traits\RepositoriesTrait;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Interfaces\AppErrorInterface;
use App\Service\Interfaces\AppServiceInterface;
use App\Service\Interfaces\TelegramServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppService extends AbstractController implements AppServiceInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var bool
     */
    protected bool $testMode;

    /**
     * @var ObjectManager
     */
    protected ObjectManager $entityManager;

    /**
     * @var TelegramServiceInterface
     */
    protected TelegramServiceInterface $telegramService;

    /**
     * @var AppErrorInterface[]
     */
    protected array $errors;

    use BusinessTrait;

    use RepositoriesTrait;

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
        $this->setEntityManager($doctrine->getManager())
            ->setTelegramService($telegramService)
            ->setTestMode($testMode)
            ->setErrors();
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return bool bool
     */
    public function getTestMode(): bool
    {
        return $this->testMode;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setTestMode(bool $testMode): self
    {
        $this->testMode = $testMode;

        return $this;
    }

    /**
     * @inheritDoc
     * @return ObjectManager ObjectManager
     */
    public function getEntityManager(): ObjectManager
    {
        return $this->entityManager;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setEntityManager(ObjectManager $entityManager): self
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    /**
     * @inheritDoc
     * @return TelegramServiceInterface TelegramServiceInterface
     */
    public function getTelegramService(): TelegramServiceInterface
    {
        return $this->telegramService;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setTelegramService(TelegramServiceInterface $telegramService): self
    {
        $this->telegramService = $telegramService;

        return $this;
    }

    /**
     * @inheritDoc
     * @return array array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setErrors(array $errors = array()): self
    {
        $this->errors = $errors;

        return $this;
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @param string $domain
     * @return bool
     * @noinspection PhpDocMissingThrowsInspection
     * @noinspection PhpUnhandledExceptionInspection
     */
    public function setBusinessContext(string $domain): bool
    {
        $business = $this->getBusinessRepository()->findByDomain($domain);
        if ($business === NULL):
            $this->registerAppError(
                ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__),
                AppError::ERROR_BUSINESS_CONTEXT,
                sprintf('Error al establecer el contexto de Business: Dominio %s no encontrado.', $domain)
            );
        else:
            $this->setBusiness($business);
        endif;

        return $business !== NULL;
    }

    /**
     * @inheritDoc
     * @return bool bool
     */
    public function persistAndFlush(ORMInterface $object): bool
    {
        $persisted = FALSE;
        if (!$this->getTestMode()):
            try {
                $entityManager = $this->getEntityManager();
                $entityManager->persist($object);
                $entityManager->flush();
                $persisted = TRUE;
            } catch (Exception $e) {
                $this->registerPersistException(
                    ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__),
                    $e->getCode(),
                    $e->getMessage(),
                    $e->getTrace()
                );
            }
        endif;

        return $persisted;
    }

    /**
     * @inheritDoc
     * @return AppErrorInterface AppErrorInterface
     */
    public function registerPersistException(string $method, int $exceptionCode, string $exceptionMessage,
                                             array  $exceptionTrace): AppErrorInterface
    {
        return $this->registerAppError(
            $method,
            AppError::ERROR_ORM_PERSIST,
            'Error al persistir entidad ORM',
            $exceptionCode,
            $exceptionMessage,
            $exceptionTrace,
            TRUE,
            FALSE
        );
    }

    /**
     * @inheritDoc
     * @return AppErrorInterface AppErrorInterface
     */
    public function registerAppError(string  $method, int $type, string $message, ?int $exceptionCode = NULL,
                                     ?string $exceptionMessage = NULL, array $exceptionTrace = array(),
                                     bool    $notify = TRUE, bool $persist = TRUE): AppErrorInterface
    {
        $appError = new AppError(
            $type,
            $method,
            $message,
            $exceptionCode,
            $exceptionMessage,
            $exceptionTrace
        );
        $this->_addAppError($appError);

        if ($persist): $this->persistAndFlush($appError); endif;
        if ($notify): $this->getTelegramService()->sendNotificationAppError($appError); endif;

        return $appError;
    }

    /**
     * @inheritDoc
     * @return AppErrorInterface AppErrorInterface
     */
    public function registerAppError_BusinessContextUndefined(string $method): AppErrorInterface
    {
        return $this->registerAppError(
            $method,
            AppError::ERROR_BUSINESS_CONTEXT,
            'Contexto de Business no establecido.'
        );
    }

    /**
     * @inheritDoc
     * @return AppErrorInterface AppErrorInterface
     */
    public function registerAppError_UserContextUndefined(string  $method): AppErrorInterface
    {
        return $this->registerAppError(
            $method,
            AppError::ERROR_USER_CONTEXT,
            'Contexto de usuario no establecido.'
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /**
     * Adds a new AppError registered in a Service.
     *
     * @param AppError $appError The error to add in the AppService.
     */
    protected function _addAppError(AppError $appError)
    {
        $this->errors[] = $appError;
    }

    /*********************************************** STATIC METHODS ***********************************************/

}