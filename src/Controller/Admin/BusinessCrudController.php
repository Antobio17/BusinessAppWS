<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Business;
use App\Entity\PostalAddress;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use App\Controller\Admin\Interfaces\BusinessCrudControllerInterface;

class BusinessCrudController extends AbstractCrudController implements BusinessCrudControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    /******************************************** GETTERS AND SETTERS *********************************************/

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
            $queryBuilder->andWhere('entity.id = :id');
            $queryBuilder->setParameter('id', $business->getID());
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
            ->setEntityLabelInSingular('Negocio')
            ->setEntityLabelInPlural('Negocios')
            ->setDateFormat('H:i:s d-m-Y')
            ->setSearchFields(['domain', 'name', 'phoneNumber', 'email'])
            ->setPageTitle(Crud::PAGE_NEW, 'Nuevo Negocio')
            ->setHelp(
                Crud::PAGE_NEW,
                'En esta vista podrás crear una nueva entidad con los datos que sean especificados.'
            )
            ->setPageTitle(Crud::PAGE_DETAIL, 'Ver Negocio')
            ->setHelp(
                Crud::PAGE_DETAIL,
                'En esta vista podrás ver la entidad seleccionada pero no editarla.'
            )
            ->setPageTitle(Crud::PAGE_EDIT, 'Editar Negocio')
            ->setHelp(
                Crud::PAGE_EDIT,
                'En esta vista podrás editar la entidad seleccionada.'
            );
    }

    /**
     * @inheritDoc
     * @return iterable iterable
     */
    public function configureFields(string $pageName): iterable
    {
        return array(
            IdField::new('id')->hideOnForm(),
            TextField::new('domain', 'Dominio'),
            TextField::new('name', 'Nombre'),
            TextField::new('phoneNumber', 'Teléfono'),
            TextField::new('email'),
        );
    }

    /**
     * @inheritDoc
     * @return Actions Actions
     */
    public function configureActions(Actions $actions): Actions
    {
        parent::configureActions($actions);

        return $actions
            # PAGE_INDEX
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Nuevo Negocio');
            });
    }

    /**
     * @param string $entityFqcn
     * @return Business Business
     */
    public function createEntity(string $entityFqcn): Business
    {
        return new Business('', '', '', new PostalAddress('', '', '', '', '', '', ''), array());
    }

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public static function getEntityFqcn(): string
    {
        return Business::class;
    }

}
