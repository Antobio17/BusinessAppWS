<?php

namespace App\Repository;

use DateTime;
use App\Entity\Interfaces\BusinessInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Interfaces\AppRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Repository of App.
 */
abstract class AppRepository extends ServiceEntityRepository implements AppRepositoryInterface
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

    /**
     * @inheritDoc
     * @return array array
     */
    public function findByStatus(BusinessInterface $business, ?int $status = NULL, ?UserInterface $user = NULL,
                                 bool              $isWorker = FALSE, ?DateTime $startDate = NULL,
                                 ?DateTime         $endDate = NULL, bool $resultAsArray = TRUE): array
    {
        $alias = 'ety';

        $queryBuilder = $this->createQueryBuilder($alias)
            ->andWhere(sprintf('%s.business = :business', $alias))
            ->setParameter('business', $business->getID());

        # Add optionals parameters.
        if ($status !== NULL):
            $queryBuilder->andWhere(sprintf('%s.status = :status', $alias))
                ->setParameter('status', $status);
        endif;
        if ($user !== NULL):
            if ($isWorker):
                $property = 'worker';
            else:
                $property = 'user';
            endif;
            /** @noinspection PhpPossiblePolymorphicInvocationInspection */
            $queryBuilder->andWhere(sprintf('%s.%s = :%s', $alias, $property, $property))
                ->setParameter($property, $user->getID());
        endif;
        if ($startDate !== NULL):
            $queryBuilder->andWhere(sprintf('%s.bookingDateAt >= :startDate', $alias))
                ->setParameter('startDate', $startDate);
        endif;
        if ($endDate !== NULL):
            $queryBuilder->andWhere(sprintf('%s.bookingDateAt <= :endDate', $alias))
                ->setParameter('endDate', $endDate);
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