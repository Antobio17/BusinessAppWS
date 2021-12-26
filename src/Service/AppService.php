<?php

namespace App\Service;

use App\Entity\AbstractORM;
use App\Entity\AppError;
use App\Entity\Interfaces\AbstractORMInterface;
use App\Helper\ToolsHelper;
use App\Service\Interfaces\AppServiceInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppService extends AbstractController implements AppServiceInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var bool
     */
    private bool $testMode;

    /**
     * @var ObjectManager
     */
    private ObjectManager $entityManager;

    /************************************************* CONSTRUCT **************************************************/

    /**
     * AppService construct.
     */
    public function __construct(ManagerRegistry $doctrine, bool $testMode = FALSE)
    {
        $this->setEntityManager($doctrine->getManager())
            ->setTestMode($testMode);
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

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @param AbstractORM $object
     */
    public function persistAndFlush(AbstractORMInterface $object): bool
    {
        $persisted = FALSE;
        if ($this->getTestMode()):
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

    public function registerPersistException(string $method, int $exceptionCode, string $exceptionMessage,
                                             array  $exceptionTrace)
    {
        $this->registerAppError(
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

    public function registerAppError(string  $method, int $type, string $message, ?int $exceptionCode = NULL,
                                     ?string $exceptionMessage = NULL, array $exceptionTrace = array(),
                                     bool    $notify = TRUE, bool $persist = TRUE): AppError
    {
        $appError = new AppError(
            $type, $method . ': ' . $message, $exceptionCode, $exceptionMessage, $exceptionTrace
        );

        if ($persist):
            $this->persistAndFlush($appError);
        endif;

        if ($notify):
            # TODO notificación telegram
        endif;

        return $appError;
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}