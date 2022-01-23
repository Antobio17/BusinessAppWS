<?php

namespace App\Service\Traits\Interfaces;

use App\Repository\Interfaces\AppErrorRepositoryInterface;
use App\Repository\UserRepository;

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

    /**
     * Facade that returns an instance of the UserRepository.
     *
     * @return UserRepository UserRepository
     */
    public function getUserRepository(): UserRepository;

    /*********************************************** STATIC METHODS ***********************************************/

}