<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Interfaces\CategoryRepositoryInterface;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends AppRepository implements CategoryRepositoryInterface
{

    /************************************************* CONSTRUCT **************************************************/

    /**
     * CategoryRepository constructor.
     *
     * @param ManagerRegistry $registry Object managers for a Doctrine persistence layer ManagerRegistry class.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @inheritDoc
     * @return array
     */
    public function findByIDs(array $categoryIDs, bool $resultAsArray = TRUE): array
    {
        $alias = 'cat';

        $query = $this->createQueryBuilder($alias)
            ->andWhere(sprintf('%s.id IN (:categoryIDs)', $alias))
            ->setParameter('categoryIDs', $categoryIDs)
            ->orderBy(sprintf('%s.name', $alias), 'ASC')
            ->getQuery();

        if ($resultAsArray):
            $result = $query->getArrayResult();
        else:
            $result = $query->execute();
        endif;

        return $result;
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}