<?php

namespace App\Service\Traits;

use App\Entity\Category;
use App\Entity\HomeConfig;
use App\Entity\Image;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Shift;
use App\Entity\User;
use App\Entity\AppError;
use App\Entity\Business;
use App\Entity\Appointment;
use App\Entity\PostalAddress;
use App\Repository\CategoryRepository;
use App\Repository\Interfaces\CategoryRepositoryInterface;
use App\Repository\Interfaces\HomeConfigRepositoryInterface;
use App\Repository\Interfaces\ImageRepositoryInterface;
use App\Repository\Interfaces\ShiftRepositoryInterface;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Repository\BusinessRepository;
use App\Repository\AppointmentRepository;
use App\Repository\PostalAddressRepository;
use App\Repository\Interfaces\AppErrorRepositoryInterface;
use App\Service\Traits\Interfaces\HasRepositoriesInterface;

/**
 * Trait to implement Repositories property.
 *
 * @see HasRepositoriesInterface
 */
trait RepositoriesTrait
{

    /************************************************* PROPERTIES *************************************************/

    /******************************************** GETTERS AND SETTERS *********************************************/

    /************************************************* CONSTRUCT **************************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return AppErrorRepositoryInterface AppErrorRepositoryInterface
     */
    public function getAppErrorRepository(): AppErrorRepositoryInterface
    {
        return $this->getEntityManager()->getRepository(AppError::class);
    }

    /**
     * @inheritDoc
     * @return UserRepository UserRepository
     */
    public function getUserRepository(): UserRepository
    {
        return $this->getEntityManager()->getRepository(User::class);
    }

    /**
     * @inheritDoc
     * @return BusinessRepository BusinessRepository
     */
    public function getBusinessRepository(): BusinessRepository
    {
        return $this->getEntityManager()->getRepository(Business::class);
    }

    /**
     * @inheritDoc
     * @return PostalAddressRepository PostalAddressRepository
     */
    public function getPostalAddressRepository(): PostalAddressRepository
    {
        return $this->getEntityManager()->getRepository(PostalAddress::class);
    }

    /**
     * @inheritDoc
     * @return AppointmentRepository AppointmentRepository
     */
    public function getAppointmentRepository(): AppointmentRepository
    {
        return $this->getEntityManager()->getRepository(Appointment::class);
    }

    /**
     * @inheritDoc
     * @return OrderRepository OrderRepository
     */
    public function getOrderRepository(): OrderRepository
    {
        return $this->getEntityManager()->getRepository(Order::class);
    }

    /**
     * @inheritDoc
     * @return ProductRepository ProductRepository
     */
    public function getProductRepository(): ProductRepository
    {
        return $this->getEntityManager()->getRepository(Product::class);
    }

    /**
     * @inheritDoc
     * @return CategoryRepositoryInterface CategoryRepositoryInterface
     */
    public function getCategoryRepository(): CategoryRepositoryInterface
    {
        return $this->getEntityManager()->getRepository(Category::class);
    }

    /**
     * @inheritDoc
     * @return HomeConfigRepositoryInterface HomeConfigRepositoryInterface
     */
    public function getHomeConfigRepository(): HomeConfigRepositoryInterface
    {
        return $this->getEntityManager()->getRepository(HomeConfig::class);
    }

    /**
     * @inheritDoc
     * @return ShiftRepositoryInterface ShiftRepositoryInterface
     */
    public function getShiftRepository(): ShiftRepositoryInterface
    {
        return $this->getEntityManager()->getRepository(Shift::class);
    }

    /**
     * @inheritDoc
     * @return ImageRepositoryInterface ImageRepositoryInterface
     */
    public function getImageRepository(): ImageRepositoryInterface
    {
        return $this->getEntityManager()->getRepository(Image::class);
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}