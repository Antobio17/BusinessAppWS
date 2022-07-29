<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use App\Controller\Admin\Interfaces\CrudControllerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController as EAAbstractCrudController;

abstract class AbstractCrudController extends EAAbstractCrudController implements CrudControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var EntityRepository
     */
    protected EntityRepository $entityRepository;

    /************************************************* CONSTRUCT **************************************************/

    /**
     * AbstractCrudController construct
     *
     * @param EntityRepository $entityRepository EntityRepository to override the query builds.
     */
    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return EntityRepository EntityRepository
     */
    public function getEntityRepository(): EntityRepository
    {
        return $this->entityRepository;
    }

    /************************************************** ROUTING ***************************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return QueryBuilder QueryBuilder
     */
    public function createIndexQueryBuilder(SearchDto        $searchDto, EntityDto $entityDto, FieldCollection $fields,
                                            FilterCollection $filters): QueryBuilder
    {
        if ($this->getUser() instanceof User):
            /** @noinspection PhpPossiblePolymorphicInvocationInspection */
            $business = $this->getUser()->getBusiness();
        endif;

        $queryBuilder = $this->getEntityRepository()->createQueryBuilder($searchDto, $entityDto, $fields, $filters);

        if (isset($business)):
            $queryBuilder->andWhere('entity.business = :business');
            $queryBuilder->setParameter('business', $business->getID());
        endif;

        return $queryBuilder;
    }

    /*********************************************** STATIC METHODS ***********************************************/

}
