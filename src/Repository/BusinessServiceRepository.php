<?php

namespace App\Repository;

use App\Entity\BusinessService;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Interfaces\BusinessServiceRepositoryInterface;

/**
 * @method BusinessService|null find($id, $lockMode = null, $lockVersion = null)
 * @method BusinessService|null findOneBy(array $criteria, array $orderBy = null)
 * @method BusinessService[]    findAll()
 * @method BusinessService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BusinessServiceRepository extends AppRepository implements BusinessServiceRepositoryInterface
{

    /************************************************* CONSTRUCT **************************************************/

    /**
     * CategoryRepository constructor.
     *
     * @param ManagerRegistry $registry Object managers for a Doctrine persistence layer ManagerRegistry class.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BusinessService::class);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}