<?php

namespace App\Entity\Traits\Interfaces;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * WorkerTrait interface
 */
interface HasWorkerInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Worker property.
     *
     * @return UserInterface UserInterface
     */
    public function getWorker(): UserInterface;

    /**
     * Sets the Worker property.
     *
     * @param UserInterface $worker The Worker to be set.
     *
     * @return $this $this
     */
    public function setWorker(UserInterface $worker): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'worker' => $this->>getWorker()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}