<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use App\Entity\Interfaces\BusinessInterface;
use App\Repository\Interfaces\ProductRepositoryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends AppRepository implements ProductRepositoryInterface
{

    /************************************************* CONSTANTS **************************************************/

    public const SORT_TYPE_MORE_RECENT = 'moreRecent';
    public const SORT_TYPE_LOWEST_PRICE = 'lowestPrice';
    public const SORT_TYPE_HIGHEST_PRICE = 'highestPrice';

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
    public function findByFilters(BusinessInterface $business, ?int $offset = NULL, ?int $limit = NULL,
                                  ?string           $sort = NULL, bool $onStock = TRUE, bool $outOfStock = TRUE,
                                  array             $categoryExclusion = array(), bool $resultAsArray = FALSE): array
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

        $queryBuilder = $this->_applyFilters($queryBuilder, $alias, $onStock, $outOfStock, $categoryExclusion);

        # Adding sort filters
        switch ($sort):
            case static::SORT_TYPE_HIGHEST_PRICE:
                $queryBuilder->orderBy(sprintf('%s.amount', $alias), 'DESC');
                break;

            case static::SORT_TYPE_LOWEST_PRICE:
                $queryBuilder->orderBy(sprintf('%s.amount', $alias), 'ASC');
                break;

            case static::SORT_TYPE_MORE_RECENT:
            default:
                $queryBuilder->orderBy(sprintf('%s.id', $alias), 'DESC');
                break;
        endswitch;

        $query = $queryBuilder->getQuery();
        if ($resultAsArray):
            $result = $query->getArrayResult();
        else:
            $result = $query->execute();
        endif;

        return $result;
    }

    /**
     * @inheritDoc
     * @return array array
     */
    public function findProductCategoryIDs(BusinessInterface $business): array
    {
        $alias = 'pdt';
        $aliasCategory = 'cat';

        $queryBuilder = $this->createQueryBuilder($alias)
            ->select(sprintf('%s.id', $aliasCategory))
            ->andWhere(sprintf('%s.business = :business', $alias))
            ->setParameter('business', $business->getID())
            ->join(sprintf('%s.category', $alias), $aliasCategory)
            ->distinct();

        return $queryBuilder->getQuery()->execute();
    }

    /**
     * @inheritDoc
     * @return int int
     */
    public function getCount(BusinessInterface $business, bool $onStock = TRUE, bool $outOfStock = TRUE,
                             array             $categoryExclusion = array()): int
    {
        $alias = 'ent';

        $queryBuilder = $this->createQueryBuilder($alias);
        $queryBuilder->select($queryBuilder->expr()->count($alias))
            ->andWhere(sprintf('%s.business = :business', $alias))
            ->setParameter('business', $business->getID());

        $queryBuilder = $this->_applyFilters($queryBuilder, $alias, $onStock, $outOfStock, $categoryExclusion);

        $count = NULL;
        try {
            $count = $queryBuilder->getQuery()->getSingleScalarResult();
        } catch (NoResultException | NonUniqueResultException $e) {
        }

        return is_numeric($count) ? (int)$count : 0;
    }

    /********************************************* PROTECTED METHODS **********************************************/

    /**
     * Method to apply filters to a search of products.
     *
     * @param QueryBuilder $queryBuilder Query builder where apply the filtres.
     * @param string $alias The alias of the entity.
     * @param bool $onStock Include the products with stock available.
     * @param bool $outOfStock Include the products with stock not available.
     * @param array $categoryExclusion The categories selected to exclude from search.
     *
     * @return QueryBuilder QueryBuilder
     */
    protected function _applyFilters(QueryBuilder $queryBuilder, string $alias, bool $onStock = TRUE,
                                     bool         $outOfStock = TRUE, array $categoryExclusion = array()): QueryBuilder
    {
        # Adding Stock filters
        if (!$onStock && !$outOfStock):
            $queryBuilder->andWhere(sprintf('%s.stock = :stock', $alias))
                ->setParameter('stock', -1);
        elseif (!$onStock):
            $queryBuilder->andWhere(sprintf('%s.stock = :stock', $alias))
                ->setParameter('stock', 0);
        elseif (!$outOfStock):
            $queryBuilder->andWhere(sprintf('%s.stock > :stock', $alias))
                ->setParameter('stock', 0);
        endif;

        # Adding category exclusion
        if (!empty($categoryExclusion)):
            $categoryExclusion = array_values($categoryExclusion);
            $categoryExclusion = implode(',', $categoryExclusion);
            $queryBuilder->andWhere(sprintf('%s.category NOT IN (%s)', $alias, $categoryExclusion));
        endif;

        return $queryBuilder;
    }

    /*********************************************** STATIC METHODS ***********************************************/

}