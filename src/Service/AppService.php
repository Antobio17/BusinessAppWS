<?php

namespace App\Service;

use Exception;
use App\Entity\AppError;
use App\Helper\ToolsHelper;
use Doctrine\Persistence\ObjectManager;
use App\Service\Traits\RepositoriesTrait;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Interfaces\AppErrorInterface;
use App\Entity\Interfaces\AbstractORMInterface;
use App\Service\Interfaces\AppServiceInterface;
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
     * @var AppErrorInterface[]
     */
    protected array $errors;

    use RepositoriesTrait;

    /************************************************* CONSTRUCT **************************************************/

    /**
     * AppService construct.
     */
    public function __construct(ManagerRegistry $doctrine, bool $testMode = FALSE)
    {
        $this->setEntityManager($doctrine->getManager())
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
     * @inheritDoc
     * @return bool bool
     */
    public function persistAndFlush(AbstractORMInterface $object): bool
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
            $method . ': ' . $message,
            $exceptionCode,
            $exceptionMessage,
            $exceptionTrace
        );
        $this->_addAppError($appError);

        if ($persist): $this->persistAndFlush($appError); endif;
        # TODO notificación telegram

        return $appError;
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