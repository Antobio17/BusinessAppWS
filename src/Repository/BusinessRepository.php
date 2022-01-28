<?php

namespace App\Repository;

use App\Entity\Business;
use App\Entity\Interfaces\BusinessInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Interfaces\BusinessRepositoryInterface;

/**
 * @method Business|null find($id, $lockMode = null, $lockVersion = null)
 * @method Business|null findOneBy(array $criteria, array $orderBy = null)
 * @method Business[]    findAll()
 * @method Business[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BusinessRepository extends AppRepository implements BusinessRepositoryInterface
{

    /************************************************* CONSTRUCT **************************************************/

    /**
     * BusinessRepository constructor.
     *
     * @param ManagerRegistry $registry Object managers for a Doctrine persistence layer ManagerRegistry class.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Business::class);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return BusinessInterface|null BusinessInterface|null
     * @throws NonUniqueResultException
     */
    public function findByDomain(string $domain): ?BusinessInterface
    {
        $alias = 'bus';

        return $this->createQueryBuilder($alias)
            ->andWhere($alias . '.domain = :domain')
            ->setParameter('domain', $domain)
            ->orderBy($alias . '.id', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();
    }

    /*********************************************** STATIC METHODS ***********************************************/

}