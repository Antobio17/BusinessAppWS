<?php

namespace App\Repository;

use Exception;
use App\Entity\HomeConfig;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Interfaces\BusinessInterface;
use App\Entity\Interfaces\HomeConfigInterface;
use App\Repository\Interfaces\HomeConfigRepositoryInterface;

/**
 * @method HomeConfig|null find($id, $lockMode = null, $lockVersion = null)
 * @method HomeConfig|null findOneBy(array $criteria, array $orderBy = null)
 * @method HomeConfig[]    findAll()
 * @method HomeConfig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HomeConfigRepository extends AppRepository implements HomeConfigRepositoryInterface
{

    /************************************************* CONSTRUCT **************************************************/

    /**
     * HomeConfigRepository constructor.
     *
     * @param ManagerRegistry $registry Object managers for a Doctrine persistence layer ManagerRegistry class.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HomeConfig::class);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return HomeConfigInterface|null HomeConfigInterface|null
     */
    public function findByBusiness(BusinessInterface $business): ?HomeConfigInterface
    {
        $alias = 'prd';

        $queryBuilder = $this->createQueryBuilder($alias)
            ->andWhere(sprintf('%s.business = :business', $alias))
            ->setParameter('business', $business->getID());

        try {
            $homeConfig = $queryBuilder
                ->orderBy(sprintf('%s.id', $alias), 'ASC')
                ->getQuery()
                ->getOneOrNullResult();
        } catch (Exception $e) {
        }

        return $homeConfig ?? NULL;
    }

    /*********************************************** STATIC METHODS ***********************************************/

}