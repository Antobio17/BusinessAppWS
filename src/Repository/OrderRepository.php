<?php

namespace App\Repository;

use App\Entity\Interfaces\BusinessInterface;
use App\Entity\Interfaces\OrderInterface;
use App\Entity\Order;
use App\Entity\User;
use App\Repository\Interfaces\OrderRepositoryInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method OrderInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderInterface[]    findAll()
 * @method OrderInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends AppRepository implements OrderRepositoryInterface
{

    /************************************************* CONSTRUCT **************************************************/

    /**
     * OrderRepository constructor.
     *
     * @param ManagerRegistry $registry Object managers for a Doctrine persistence layer ManagerRegistry class.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return OrderInterface|null OrderInterface|null
     */
    public function findByUUID(string $UUID): ?OrderInterface
    {
        $alias = 'ord';

        try {
            $order = $this->createQueryBuilder($alias)
                ->andWhere($alias . '.uuid = :UUID')
                ->setParameter('UUID', $UUID)
                ->getQuery()->getOneOrNullResult();
        } catch (Exception $e) {
            $order = NULL;
        }

        return $order;
    }

    /**
     * @inheritDoc
     * @return array array
     */
    public function findByUser(BusinessInterface $business, User $user, ?int $offset = NULL, ?int $limit = NULL,
                               bool $resultAsArray = TRUE): array
    {
        $alias = 'ord';

        $queryBuilder = $this->createQueryBuilder($alias)
            ->andWhere(sprintf('%s.business = :business', $alias))
            ->setParameter('business', $business->getID())
            ->andWhere(sprintf('%s.user = :user', $alias))
            ->setParameter('user', $user->getID())
            ->orderBy(sprintf('%s.id', $alias), 'DESC');

        # Add optionals parameters.
        if ($offset !== NULL):
            $queryBuilder->setFirstResult($offset);
        endif;
        if ($limit !== NULL):
            $queryBuilder->setMaxResults($limit);
        endif;

        if ($resultAsArray):
            $result = $queryBuilder->getQuery()->getArrayResult();
        else:
            $result = $queryBuilder->getQuery()->execute();
        endif;

        return $result;
    }

    /**
     * @inheritDoc
     * @return int int
     */
    public function getCountTotalOrders(BusinessInterface $business, User $user): int
    {
        $alias = 'odr';

        $queryBuilder = $this->createQueryBuilder($alias);
        $queryBuilder->select($queryBuilder->expr()->count($alias))
            ->andWhere(sprintf('%s.business = :business', $alias))
            ->setParameter('business', $business->getID())
            ->andWhere(sprintf('%s.user = :user', $alias))
            ->setParameter('user', $user->getID());

        $count = NULL;
        try {
            $count = $queryBuilder->getQuery()->getSingleScalarResult();
        } catch (NoResultException | NonUniqueResultException $e) {
        }

        return is_numeric($count) ? (int)$count : 0;
    }

    /*********************************************** STATIC METHODS ***********************************************/

}