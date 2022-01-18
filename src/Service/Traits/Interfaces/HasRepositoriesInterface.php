<?php

namespace App\Service\Traits\Interfaces;

use App\Repository\Interfaces\AppErrorRepositoryInterface;

/**
 * RepositoriesTrait interface.
 */
interface HasRepositoriesInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Facade that returns an instance of the AppErrorRepository.
     *
     * @return AppErrorRepositoryInterface AppErrorRepositoryInterface
     */
    public function getAppErrorRepository(): AppErrorRepositoryInterface;

    /*********************************************** STATIC METHODS ***********************************************/

}