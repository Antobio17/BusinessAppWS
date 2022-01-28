<?php

namespace App\Service\Traits\Interfaces;

use App\Repository\PostalAddressRepository;
use App\Repository\UserRepository;
use App\Repository\Interfaces\AppErrorRepositoryInterface;
use App\Repository\Interfaces\BusinessRepositoryInterface;

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

    /**
     * Facade that returns an instance of the BusinessRepository.
     *
     * @return BusinessRepositoryInterface BusinessRepositoryInterface
     */
    public function getBusinessRepository(): BusinessRepositoryInterface;

    /**
     * Facade that returns an instance of the PostalAddressRepository.
     *
     * @return PostalAddressRepository PostalAddressRepository
     */
    public function getPostalAddressRepository(): PostalAddressRepository;

    /*********************************************** STATIC METHODS ***********************************************/

}