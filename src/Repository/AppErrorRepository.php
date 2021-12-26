<?php

namespace App\Repository;

use App\Entity\AppError;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Interfaces\AppErrorRepositoryInterface;

/**
 * @method AppError|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppError|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppError[]    findAll()
 * @method AppError[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppErrorRepository extends AppRepository implements AppErrorRepositoryInterface
{

    /************************************************* CONSTRUCT **************************************************/

    /**
     * AppErrorRepository constructor.
     *
     * @param ManagerRegistry $registry Object managers for a Doctrine persistence layer ManagerRegistry class.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppError::class);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}