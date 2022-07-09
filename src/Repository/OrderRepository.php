<?php

namespace App\Repository;

use App\Entity\Interfaces\BusinessInterface;
use App\Entity\Interfaces\OrderInterface;
use App\Entity\Order;
use App\Entity\User;
use App\Repository\Interfaces\OrderRepositoryInterface;
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
    public function findByUser(BusinessInterface $business, User $user, bool $resultAsArray = TRUE): array
    {
        $alias = 'ord';

        $query = $this->createQueryBuilder($alias)
            ->andWhere(sprintf('%s.business = :business', $alias))
            ->setParameter('business', $business->getID())
            ->andWhere(sprintf('%s.user = :user', $alias))
            ->setParameter('user', $user->getID())
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