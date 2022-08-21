<?php

namespace App\Repository;

use App\Entity\SocialImage;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Interfaces\SocialImageRepositoryInterface;

/**
 * @method SocialImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method SocialImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method SocialImage[]    findAll()
 * @method SocialImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SocialImageRepository extends AppRepository implements SocialImageRepositoryInterface
{

    /************************************************* CONSTRUCT **************************************************/

    /**
     * CategoryRepository constructor.
     *
     * @param ManagerRegistry $registry Object managers for a Doctrine persistence layer ManagerRegistry class.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SocialImage::class);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}