<?php

namespace App\Controller\Admin;

use App\Entity\Business;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
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
            ->setDateFormat('H:i:s d-m-Y');
    }

    /**
     * @inheritDoc
     * @return iterable iterable
     */
    public function configureFields(string $pageName): iterable
    {
        return array(
            IdField::new('id'),
            TextField::new('domain', 'Dominio'),
            TextField::new('name', 'Nombre'),
            TextField::new('phoneNumber', 'Teléfono'),
            TextField::new('email'),
        );
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
