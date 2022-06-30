<?php

namespace App\Repository;

use App\Entity\Interfaces\BusinessInterface;
use App\Entity\Product;
use App\Repository\Interfaces\ProductRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends AppRepository implements ProductRepositoryInterface
{

    /************************************************* CONSTRUCT **************************************************/

    /**
     * ProductRepository constructor.
     *
     * @param ManagerRegistry $registry Object managers for a Doctrine persistence layer ManagerRegistry class.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function findByOffset(BusinessInterface $business, ?int $offset = NULL, ?int $limit = NULL,
                                 bool $resultAsArray = TRUE): array
    {
        $alias = 'prd';

        $queryBuilder = $this->createQueryBuilder($alias)
            ->andWhere(sprintf('%s.business = :business', $alias))
            ->setParameter('business', $business->getID());

        # Add optionals parameters.
        if ($offset !== NULL):
            $queryBuilder->setFirstResult($offset);
        endif;
        if ($limit !== NULL):
            $queryBuilder->setMaxResults($limit);
        endif;

        $query = $queryBuilder->orderBy(sprintf('%s.id', $alias), 'ASC')
            ->getQuery();

        if ($resultAsArray):
            $result = $query->getArrayResult();
        else:
            $result = $query->execute();
        endif;

        return $result;
    }

    /*********************************************** STATIC METHODS ***********************************************/

}