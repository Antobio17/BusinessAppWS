<?php

namespace App\Repository;

use App\Entity\Shift;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Interfaces\ShiftRepositoryInterface;

/**
 * @method Shift|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shift|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shift[]    findAll()
 * @method Shift[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShiftRepository extends AppRepository implements ShiftRepositoryInterface
{

    /************************************************* CONSTRUCT **************************************************/

    /**
     * CategoryRepository constructor.
     *
     * @param ManagerRegistry $registry Object managers for a Doctrine persistence layer ManagerRegistry class.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shift::class);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}