<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Business;
use App\Entity\PostalAddress;
use App\Form\Types\ShiftType;
use Doctrine\ORM\QueryBuilder;
use App\Form\Types\PostalAddressType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use App\Controller\Admin\Interfaces\BusinessCrudControllerInterface;

class BusinessCrudController extends AbstractCrudController implements BusinessCrudControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    /************************************************* CONSTRUCT **************************************************/

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
            /** @noinspection PhpUndefinedMethodInspection */
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
        return parent::configureCrud($crud)
            ->setEntityLabelInSingular('Negocio')
            ->setEntityLabelInPlural('Negocios')
            ->setSearchFields(array('domain', 'name', 'phoneNumber', 'email'))
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
            FormField::addPanel('Información General'),
            IdField::new('id')->hideOnForm(),
            TextField::new('domain', 'Dominio'),
            TextField::new('name', 'Nombre'),
            TextField::new('phoneNumber', 'Teléfono'),
            TextField::new('email'),
            FormField::addPanel('Dirección Postal'),
            AssociationField::new('postalAddress')
                ->hideOnIndex()
                ->setLabel(FALSE)
                ->setFormType(PostalAddressType::class)
                ->setFormTypeOptions(array(
                    'by_reference' => FALSE,
                )),
            FormField::addPanel('Horario'),
            CollectionField::new('shifts')
                ->hideWhenCreating()
                ->hideOnIndex()
                ->allowAdd(FALSE)
                ->allowDelete(FALSE)
                ->setLabel(FALSE)
                ->setEntryType(ShiftType::class)
                ->setFormTypeOptions(array(
                    'by_reference' => FALSE,
                )),
        );
    }

    /**
     * @inheritDoc
     * @return Filters Filters
     */
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add(TextFilter::new('name', 'Nombre'))
            ->add(TextFilter::new('domain', 'Dominio'))
            ->add(TextFilter::new('phoneNumber', 'Número de teléfono'))
            ->add(TextFilter::new('email', 'Email'));
    }

    /**
     * @inheritDoc
     * @return Actions Actions
     */
    public function configureActions(Actions $actions): Actions
    {
        parent::configureActions($actions);

        if (!in_array(User::ROLE_ADMIN, $this->getUser()->getRoles())):
            $actions
                ->disable('delete');
        endif;

        return $actions
            ->disable('detail')
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
