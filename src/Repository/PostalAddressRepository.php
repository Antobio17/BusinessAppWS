<?php

namespace App\Repository;

use App\Entity\PostalAddress;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Interfaces\PostalAddressRepositoryInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use function get_class;

/**
 * @method PostalAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostalAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostalAddress[]    findAll()
 * @method PostalAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostalAddressRepository extends AppRepository implements PostalAddressRepositoryInterface
{
    /**
     * PostalAddressRepository constructor.
     *
     * @param ManagerRegistry $registry Object managers for a Doctrine persistence layer ManagerRegistry class.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostalAddress::class);
    }

}
