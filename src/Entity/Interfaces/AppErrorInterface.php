<?php

namespace App\Entity\Interfaces;

use App\Entity\Traits\Interfaces\HasMessageInterface;
use App\Entity\Traits\Interfaces\HasTypeInterface;
use App\Entity\Traits\Interfaces\HasCreatedAtInterface;

/**
 * AppError interface.
 */
interface AppErrorInterface extends HasTypeInterface, HasMessageInterface, HasCreatedAtInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     * Returns array(
     *      'type' => $this->>__typeToArray(),
     *      'message' => $this->>__messageToArray(),
     *      'createdAt' => $this->>__createdAtToArray()
     * )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}