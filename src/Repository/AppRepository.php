<?php

namespace App\Repository;

use App\Entity\AppError;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Interfaces\AppRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 */
class AppRepository extends ServiceEntityRepository implements AppRepositoryInterface
{

    /************************************************* CONSTRUCT **************************************************/

    /**
     * AppRepository constructor.
     *
     * @param ManagerRegistry $registry Object managers for a Doctrine persistence layer ManagerRegistry class.
     * @param string $FQNClassName FQN class name.
     */
    public function __construct(ManagerRegistry $registry, string $FQNClassName)
    {
        parent::__construct($registry, $FQNClassName);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function findByType(int $type): array
    {
        $alias = 'ent';

        return $this->createQueryBuilder($alias)
            ->andWhere($alias . '.type = :type')
            ->setParameter('type', $type)
            ->orderBy($alias . '.id', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }

    /*********************************************** STATIC METHODS ***********************************************/

}