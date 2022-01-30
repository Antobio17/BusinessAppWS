<?php

namespace App\Repository;

use App\Entity\AppError;
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
    public function findByStatus(BusinessInterface $business, ?int $status = NULL, ?UserInterface $user = NULL): array
    {
        $alias = 'ety';

        $queryBuilder = $this->createQueryBuilder($alias)
            ->andWhere($alias . '.business = :business')
            ->setParameter('business', $business->getID());

        # Add optionals parameters.
        if ($status !== NULL):
            $queryBuilder->andWhere($alias . '.status = :status')
                ->setParameter('status', $status);
        endif;
        if ($user !== NULL):
            /** @noinspection PhpPossiblePolymorphicInvocationInspection */
            $queryBuilder->andWhere($alias . '.user = :user')
                ->setParameter('user', $user->getID());
        endif;

        return $queryBuilder->orderBy($alias . '.id', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }

    /*********************************************** STATIC METHODS ***********************************************/

}