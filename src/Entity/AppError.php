<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\TypeTrait;
use App\Entity\Traits\MethodTrait;
use App\Entity\Traits\MessageTrait;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\ArrayDataTrait;
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
    public const ERROR_BUSINESS_CONTEXT = 1;
    public const ERROR_USER_CONTEXT = 2;
    public const ERROR_JWT_SPLIT_TOKEN = 3;

    public const ERROR_TELEGRAM_API = 10;

    public const ERROR_APPOINTMENT_BOOK_USER_UNDEFINED = 20;
    public const ERROR_APPOINTMENT_BOOK_USER_NOT_EXIST = 21;
    public const ERROR_APPOINTMENT_BOOK_ALREADY_EXIST = 22;
    public const ERROR_APPOINTMENT_BOOK_DATE_INTERVAL = 23;
    public const ERROR_APPOINTMENT_BOOK_ERROR = 24;

    public const ERROR_STORE_INCORRECT_POSTAL_ADDRESS = 40;
    public const ERROR_STORE_UUID_EXIST = 41;
    public const ERROR_STORE_INCORRECT_ORDER = 41;

    public const ERROR_USER_WRONG_POSTAL_ADDRESS = 60;

    public const ERROR_BUSINESS_HOME_CONFIG_UNDEFINED = 71;

    /************************************************* PROPERTIES *************************************************/

    use TypeTrait {
        TypeTrait::__construct as protected __typeConstruct;
        TypeTrait::__toArray as protected __typeToArray;
    }

    use MethodTrait {
        MethodTrait::__construct as protected __methodConstruct;
        MethodTrait::__toArray as protected __methodToArray;
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
     * @param string $method Method of the AppError.
     * @param string $message Message of the AppError.
     * @param int|null $exceptionCode Code of the exception catch.
     * @param string|null $exceptionMessage Message of the exception catch.
     * @param array $exceptionTrace Trace of the exception catch.
     * @param DateTime|null $createdAt Error creation date.
     */
    public function __construct(int $type, string $method, string $message, ?int $exceptionCode = NULL,
                                ?string $exceptionMessage = NULL, array $exceptionTrace = array(),
                                DateTime $createdAt = NULL)
    {
        $this->__typeConstruct($type);
        $this->__methodConstruct($method);
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
     * @return int|null int|null
     */
    public function getExceptionCode(): ?int
    {
        return $this->getArrayData()['exceptionCode'];
    }

    /**
     * @inheritDoc
     * @return string|null string|null
     */
    public function getExceptionMessage(): ?string
    {
        return $this->getArrayData()['exceptionMessage'];
    }

    /**
     * @inheritDoc
     * @return array|null array|null
     */
    public function getExceptionTrace(): ?array
    {
        return $this->getArrayData()['exceptionTrace'];
    }

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array_merge(
            $this->__typeToArray(),
            $this->__methodToArray(),
            $this->__messageToArray(),
            $this->__arrayDataToArray(),
            $this->__createdAtToArray()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}