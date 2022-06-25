<?php

namespace App\Service\Traits\Interfaces;

use App\Repository\AppointmentRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Repository\PostalAddressRepository;
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

    /**
     * Facade that returns an instance of the AppointmentRepository.
     *
     * @return AppointmentRepository AppointmentRepository
     */
    public function getAppointmentRepository(): AppointmentRepository;

    /**
     * Facade that returns an instance of the OrderRepository.
     *
     * @return OrderRepository OrderRepository
     */
    public function getOrderRepository(): OrderRepository;

    /**
     * Facade that returns an instance of the ProductRepository.
     *
     * @return ProductRepository ProductRepository
     */
    public function getProductRepository(): ProductRepository;

    /*********************************************** STATIC METHODS ***********************************************/

}