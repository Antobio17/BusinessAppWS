<?php

namespace App\Repository;

use App\Entity\AppError;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Interfaces\AppErrorRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method AppError|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppError|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppError[]    findAll()
 * @method AppError[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppErrorRepository extends ServiceEntityRepository implements AppErrorRepositoryInterface
{

    /************************************************* CONSTRUCT **************************************************/

    /**
     * AppError constructor.
     *
     * @param ManagerRegistry $registry Object managers for a Doctrine persistence layer ManagerRegistry class.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppError::class);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function findByType(int $type): array
    {
        $alias = 'err';

        return $this->createQueryBuilder($alias)
            ->andWhere($alias . '.type = :type')
            ->setParameter('type', $type)
            ->orderBy($alias . '.id', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }

    /*********************************************** STATIC METHODS ***********************************************/

}