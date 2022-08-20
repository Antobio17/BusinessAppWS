<?php

namespace App\Repository;

use App\Entity\Image;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Interfaces\ImageRepositoryInterface;

/**
 * @method Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Image[]    findAll()
 * @method Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRepository extends AppRepository implements ImageRepositoryInterface
{

    /************************************************* CONSTRUCT **************************************************/

    /**
     * CategoryRepository constructor.
     *
     * @param ManagerRegistry $registry Object managers for a Doctrine persistence layer ManagerRegistry class.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Image::class);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}