<?php

namespace App\Service\Traits;

use App\Entity\User;
use App\Entity\AppError;
use App\Entity\Business;
use App\Entity\Appointment;
use App\Entity\PostalAddress;
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

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}