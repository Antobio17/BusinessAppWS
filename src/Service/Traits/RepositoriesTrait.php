<?php

namespace App\Service\Traits;

use App\Entity\AppError;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AppErrorRepository;
use App\Repository\Interfaces\AppErrorRepositoryInterface;
use App\Service\Traits\Interfaces\HasRepositoriesInterface;

/**
 * Trait to implement _Template_ property.
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

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}