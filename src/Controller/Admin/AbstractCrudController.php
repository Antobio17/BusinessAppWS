<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
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

    /**
     * @inheritDoc
     * @return Crud Crud
     */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            # Date, Time and Number Formatting Options
            ->setDateFormat('H:i:s d-m-Y')
            # Search and Pagination Options
            ->setSearchFields(array('id'))
            ->setDefaultSort(array('id' => 'DESC'))
            ->setPaginatorPageSize(25)
            # Other
            ->showEntityActionsInlined();
    }

    /**
     * @inheritDoc
     * @return Actions Actions
     */
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            # PAGE_INDEX
            ->disable('delete')
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setIcon('fa fa-eye')->setLabel(FALSE);
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setIcon('fa fa-pencil')->setLabel(FALSE);
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setIcon('fa fa-trash')->setLabel(FALSE);
            })
            # PAGE_NEW
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Crear');
            })
            # PAGE_EDIT
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE, function (Action $action) {
                return $action->setLabel('Guardar y continuar');
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Guardar cambios');
            });
    }

    /*********************************************** STATIC METHODS ***********************************************/

}
