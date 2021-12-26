<?php

namespace App\Entity;

use App\Entity\Interfaces\AppErrorInterface;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\MessageTrait;
use App\Entity\Traits\TypeTrait;
use DateTime;

/**
 *
 */
class AppError extends AbstractORM implements AppErrorInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    use TypeTrait {
        TypeTrait::__construct as protected __typeConstruct;
        TypeTrait::__toArray as protected __typeToArray;
    }

    use MessageTrait {
        MessageTrait::__construct as protected __messageConstruct;
        MessageTrait::__toArray as protected __messageToArray;
    }

    use CreatedAtTrait {
        CreatedAtTrait::__construct as protected __createdAtConstruct;
        CreatedAtTrait::__toArray as protected __createdAtToArray;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  AppError constructor.
     */
    public function __construct(int $type, string $message, DateTime $createdAt = NULL)
    {
        $this->__typeConstruct($type);
        $this->__messageConstruct($message);
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
            $this->__createdAtToArray()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}