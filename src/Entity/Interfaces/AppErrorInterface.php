<?php

namespace App\Entity\Interfaces;

use App\Entity\Traits\Interfaces\HasArrayDataInterface;
use App\Entity\Traits\Interfaces\HasMessageInterface;
use App\Entity\Traits\Interfaces\HasMethodInterface;
use App\Entity\Traits\Interfaces\HasTypeInterface;
use App\Entity\Traits\Interfaces\HasCreatedAtInterface;

/**
 * AppError interface.
 */
interface AppErrorInterface extends HasTypeInterface, HasMessageInterface, HasCreatedAtInterface, HasArrayDataInterface,
    HasMethodInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Gets the exception code of the error.
     *
     * @return int|null int|null
     */
    public function getExceptionCode(): ?int;

    /**
     * Gets the exception message of the error.
     *
     * @return string|null string|null
     */
    public function getExceptionMessage(): ?string;

    /**
     * Gets the exception trace of the error.
     *
     * @return array|null array|null
     */
    public function getExceptionTrace(): ?array;

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'type' => $this->>__typeToArray(),
     *          'message' => $this->>__messageToArray(),
     *          'createdAt' => $this->>__createdAtToArray()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}