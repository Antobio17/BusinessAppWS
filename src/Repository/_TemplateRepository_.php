<?php

namespace App\Repository;

use App\Entity\_Template_;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use App\Repository\Interfaces\_TemplateRepositoryInterface_;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method _Template_|null find($id, $lockMode = null, $lockVersion = null)
 * @method _Template_|null findOneBy(array $criteria, array $orderBy = null)
 * @method _Template_[]    findAll()
 * @method _Template_[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class _TemplateRepository_ extends ServiceEntityRepository implements _TemplateRepositoryInterface_
{

    /************************************************* CONSTRUCT **************************************************/

    /**
     * _Template_ constructor.
     *
     * @param ManagerRegistry $registry Object managers for a Doctrine persistence layer ManagerRegistry class.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, _Template_::class);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}