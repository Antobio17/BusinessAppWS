<?php

namespace App\Service\Traits;

use App\Entity\AppError;
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

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}