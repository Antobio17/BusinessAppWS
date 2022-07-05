<?php

namespace App\Repository;

use App\Entity\Interfaces\PostalAddressInterface;
use App\Entity\PostalAddress;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Interfaces\PostalAddressRepositoryInterface;
use Exception;

/**
 * @method PostalAddressInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostalAddressInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostalAddressInterface[]    findAll()
 * @method PostalAddressInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostalAddressRepository extends AppRepository implements PostalAddressRepositoryInterface
{

    /************************************************* CONSTRUCT **************************************************/

    /**
     * PostalAddressRepository constructor.
     *
     * @param ManagerRegistry $registry Object managers for a Doctrine persistence layer ManagerRegistry class.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostalAddress::class);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}
