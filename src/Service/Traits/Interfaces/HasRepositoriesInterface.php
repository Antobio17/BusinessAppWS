<?php

namespace App\Service\Traits\Interfaces;

use App\Repository\UserRepository;
use App\Repository\Interfaces\OrderRepositoryInterface;
use App\Repository\Interfaces\ProductRepositoryInterface;
use App\Repository\Interfaces\AppErrorRepositoryInterface;
use App\Repository\Interfaces\BusinessRepositoryInterface;
use App\Repository\Interfaces\CategoryRepositoryInterface;
use App\Repository\Interfaces\AppointmentRepositoryInterface;
use App\Repository\Interfaces\PostalAddressRepositoryInterface;

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
     * @return PostalAddressRepositoryInterface PostalAddressRepositoryInterface
     */
    public function getPostalAddressRepository(): PostalAddressRepositoryInterface;

    /**
     * Facade that returns an instance of the AppointmentRepository.
     *
     * @return AppointmentRepositoryInterface AppointmentRepositoryInterface
     */
    public function getAppointmentRepository(): AppointmentRepositoryInterface;

    /**
     * Facade that returns an instance of the OrderRepository.
     *
     * @return OrderRepositoryInterface OrderRepositoryInterface
     */
    public function getOrderRepository(): OrderRepositoryInterface;

    /**
     * Facade that returns an instance of the ProductRepository.
     *
     * @return ProductRepositoryInterface ProductRepositoryInterface
     */
    public function getProductRepository(): ProductRepositoryInterface;

    /**
     * Facade that returns an instance of the CategoryRepository.
     *
     * @return CategoryRepositoryInterface CategoryRepositoryInterface
     */
    public function getCategoryRepository(): CategoryRepositoryInterface;

    /*********************************************** STATIC METHODS ***********************************************/

}