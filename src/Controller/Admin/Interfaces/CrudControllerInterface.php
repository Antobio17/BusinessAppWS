<?php

namespace App\Controller\Admin\Interfaces;

use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;

interface CrudControllerInterface
{

    /************************************************** ROUTING ***************************************************/

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the EntityRepository property of the controller.
     *
     * @return EntityRepository EntityRepository
     */
    public function getEntityRepository(): EntityRepository;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Method to create the index query builder and apply filters in the list view of the entities.
     * @param SearchDto $searchDto
     * @param EntityDto $entityDto
     * @param FieldCollection $fields
     * @param FilterCollection $filters
     *
     * @return QueryBuilder QueryBuilder
     */
    public function createIndexQueryBuilder(SearchDto        $searchDto, EntityDto $entityDto, FieldCollection $fields,
                                            FilterCollection $filters): QueryBuilder;

    /**
     * Method to configure the actions of the views.
     *
     * @param Actions $actions Actions to configure.
     *
     * @return Actions Actions
     */
    public function configureActions(Actions $actions): Actions;

    /*********************************************** STATIC METHODS ***********************************************/

}