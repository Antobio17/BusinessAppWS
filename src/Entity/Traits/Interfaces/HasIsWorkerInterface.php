<?php

namespace App\Entity\Traits\Interfaces;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * IsWorkerTrait interface
 */
interface HasIsWorkerInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the IsWorker property.
     *
     * @return bool bool
     */
    public function getIsWorker(): bool;

    /**
     * Sets the IsWorker property.
     *
     * @param bool $isWorker The IsWorker to be set.
     *
     * @return $this $this
     */
    public function setIsWorker(bool $isWorker): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'isWorker' => $this->>getIsWorker()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}