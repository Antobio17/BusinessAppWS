<?php

namespace App\Entity\Traits\Interfaces;

use App\Entity\Traits\MessageTrait;

/**
 * MessageTrait interface
 */
interface HasMessageInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Message property.
     *
     * @return string string
     */
    public function getMessage(): string;

    /**
     * Sets the Message property.
     *
     * @param string $message The message to be set.
     * @return $this $this
     */
    public function setMessage(string $message): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     * Returns array(
     *      'message' => $this->>getMessage()
     * )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}