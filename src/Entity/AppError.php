<?php

namespace App\Entity;

use App\Entity\Traits\ArrayDataTrait;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\TypeTrait;
use App\Entity\Traits\MessageTrait;
use App\Entity\Traits\CreatedAtTrait;
use App\Repository\AppErrorRepository;
use App\Entity\Interfaces\AppErrorInterface;

/**
 * AppError entity
 *
 * @ORM\Entity(repositoryClass=AppErrorRepository::class)
 */
class AppError extends AbstractORM implements AppErrorInterface
{

    /************************************************* CONSTANTS **************************************************/

    public const ERROR_ORM_PERSIST = 0;

    /************************************************* PROPERTIES *************************************************/

    use TypeTrait {
        TypeTrait::__construct as protected __typeConstruct;
        TypeTrait::__toArray as protected __typeToArray;
    }

    use MessageTrait {
        MessageTrait::__construct as protected __messageConstruct;
        MessageTrait::__toArray as protected __messageToArray;
    }

    use ArrayDataTrait {
        ArrayDataTrait::__construct as protected __arrayDataConstruct;
        ArrayDataTrait::__toArray as protected __arrayDataToArray;
    }

    use CreatedAtTrait {
        CreatedAtTrait::__construct as protected __createdAtConstruct;
        CreatedAtTrait::__toArray as protected __createdAtToArray;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  AppError constructor.
     *
     * @param int $type Type of the AppError.
     * @param string $message Message of the AppError.
     * @param int|null $exceptionCode Code of the exception catch.
     * @param string|null $exceptionMessage Message of the exception catch.
     * @param array $exceptionTrace Trace of the exception catch.
     * @param DateTime|null $createdAt Error creation date.
     */
    public function __construct(int $type, string $message, ?int $exceptionCode = NULL,
                                ?string $exceptionMessage = NULL, array $exceptionTrace = array(),
                                DateTime $createdAt = NULL)
    {
        $this->__typeConstruct($type);
        $this->__messageConstruct($message);
        $this->__arrayDataConstruct(array(
            'exceptionCode' => $exceptionCode,
            'exceptionMessage' => $exceptionMessage,
            'exceptionTrace' => $exceptionTrace,
        ));
        $this->__createdAtConstruct($createdAt ?? date_create());
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array_merge(
            $this->__typeToArray(),
            $this->__messageToArray(),
            $this->__arrayDataToArray(),
            $this->__createdAtToArray()
        );
    }

    # TODO getExceptionCode
    # TODO getExceptionMessage
    # TODO getExceptionTrace

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}