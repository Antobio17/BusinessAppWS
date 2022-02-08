<?php

namespace App\Entity\Traits\Interfaces;

/**
 * WorkersTrait interface
 */
interface HasWorkersInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Workers property of the Entity.
     *
     * @return array array
     */
    public function getWorkers(): array;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'workers' => $this->getWorkers()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}