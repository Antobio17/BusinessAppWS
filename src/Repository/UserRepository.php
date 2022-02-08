<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use App\Entity\Interfaces\BusinessInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use function get_class;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     * @throws ORMException
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * Finds a User searching by the email passed.
     *
     * @param BusinessInterface $business Business to which the user belongs.
     * @param string $email Email to the searching.
     *
     * @return User|null User|null
     */
    public function findByEmail(BusinessInterface $business, string $email): ?UserInterface
    {
        $alias = 'use';

        try {
            $user = $this->createQueryBuilder($alias)
                ->andWhere($alias . '.business = :business')
                ->setParameter('business', $business)
                ->andWhere($alias . '.email = :email')
                ->setParameter('email', $email)
                ->orderBy($alias . '.id', 'ASC')
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
        }

        return $user ?? NULL;
    }

    /**
     * Finds the users of the business specified.
     *
     * @param BusinessInterface $business Business to which the user belongs.
     * @param bool $isWorkers Boolean to get only the workers of the business.
     *
     * @return array array
     */
    public function findByBusiness(BusinessInterface $business, bool $isWorkers): array
    {
        $alias = 'usr';

        return $this->createQueryBuilder($alias)
            ->andWhere(sprintf('%s.business = :business', $alias))
            ->setParameter('business', $business)
            ->andWhere(sprintf('%s.isWorker = :isWorker', $alias))
            ->setParameter('isWorker', $isWorkers)
            ->getQuery()
            ->execute();
    }

}
