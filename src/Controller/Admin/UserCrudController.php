<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\Types\PostalAddressType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use App\Controller\Admin\Interfaces\UserCrudControllerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController implements UserCrudControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var UserPasswordHasherInterface
     */
    protected UserPasswordHasherInterface $userPasswordHasher;

    /**
     * @var AuthenticationSuccessHandler
     */
    protected AuthenticationSuccessHandler $authenticationSuccessHandler;

    /**
     * @var PasswordHasherFactoryInterface
     */
    protected PasswordHasherFactoryInterface $passwordHasherFactory;

    /************************************************* CONSTRUCT **************************************************/

    /**
     * UserCrudController construct.
     *
     * @param EntityRepository $entityRepository Entity repository.
     * @param UserPasswordHasherInterface $userPasswordHasher Hasher to encode the user password.
     * @param AuthenticationSuccessHandler $authenticationSuccessHandler Handler to return a response with user's token.
     * @param PasswordHasherFactoryInterface $passwordHasherFactory The Factory PasswordHasher.
     */
    public function __construct(EntityRepository               $entityRepository,
                                UserPasswordHasherInterface    $userPasswordHasher,
                                AuthenticationSuccessHandler   $authenticationSuccessHandler,
                                PasswordHasherFactoryInterface $passwordHasherFactory)
    {
        parent::__construct($entityRepository);

        $this->setUserPasswordHasher($userPasswordHasher)
            ->setAuthenticationSuccessHandler($authenticationSuccessHandler)
            ->setPasswordHasherFactoryInterface($passwordHasherFactory);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return UserPasswordHasherInterface UserPasswordHasherInterface
     */
    public function getUserPasswordHasher(): UserPasswordHasherInterface
    {
        return $this->userPasswordHasher;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setUserPasswordHasher(UserPasswordHasherInterface $userPasswordHasher): self
    {
        $this->userPasswordHasher = $userPasswordHasher;

        return $this;
    }

    /**
     * @inheritDoc
     * @return AuthenticationSuccessHandler AuthenticationSuccessHandler
     */
    public function getAuthenticationSuccessHandler(): AuthenticationSuccessHandler
    {
        return $this->authenticationSuccessHandler;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setAuthenticationSuccessHandler(AuthenticationSuccessHandler $authenticationSuccessHandler): self
    {
        $this->authenticationSuccessHandler = $authenticationSuccessHandler;

        return $this;
    }

    /**
     * @inheritDoc
     * @return PasswordHasherFactoryInterface PasswordHasherFactoryInterface
     */
    public function getPasswordHasherFactoryInterface(): PasswordHasherFactoryInterface
    {
        return $this->passwordHasherFactory;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setPasswordHasherFactoryInterface(PasswordHasherFactoryInterface $passwordHasherFactory): self
    {
        $this->passwordHasherFactory = $passwordHasherFactory;

        return $this;
    }

    /************************************************** ROUTING ***************************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return Crud Crud
     */
    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInSingular('Usuario')
            ->setEntityLabelInPlural('Usuarios')
            ->setSearchFields(array('email'));
    }

    /**
     * @param Filters $filters
     *
     * @return Filters Filters
     */
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters);
    }

    /**
     * @inheritDoc
     * @return Crud Crud
     */
    public function configureFields(string $pageName): iterable
    {
        $disable = !in_array(User::ROLE_ADMIN, $this->getUser()->getRoles());
        return array(
            FormField::addPanel('Información General'),
            IdField::new('id')->hideOnForm(),
            AssociationField::new('business', 'Negocio')->setDisabled($disable),
            TextField::new('email', 'Email')
                ->setRequired(Crud::PAGE_NEW === $pageName),
            TextField::new('password')->setFormType(PasswordType::class)
                ->onlyWhenCreating()
                ->setRequired(Crud::PAGE_NEW === $pageName),
            TextField::new('phoneNumber', 'Teléfono'),
            TextField::new('name', 'Nombre'),
            TextField::new('surname', 'Apellidos'),
            BooleanField::new('isWorker', 'Trabajador')
                ->setDisabled($pageName !== Crud::PAGE_NEW),
            BooleanField::new('isVerified', 'Verificado'),
            FormField::addPanel('Dirección Postal')->hideWhenCreating(),
            CollectionField::new('postalAddresses')
                ->hideOnIndex()
                ->hideWhenCreating()
                ->allowAdd(FALSE)
                ->allowDelete(FALSE)
                ->setLabel(FALSE)
                ->setEntryType(PostalAddressType::class)
                ->setFormTypeOptions(array(
                    'by_reference' => FALSE,
                )),
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
            ->disable('delete')
            # PAGE_INDEX
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Nuevo Usuario');
            });
    }

    /**
     * @inheritDoc
     */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->_encodePassword($entityInstance);

        if ($entityInstance->getIsWorker()):
            $entityInstance->setRoles(array_merge($entityInstance->getRoles(), array(User::ROLE_WORKER)));
        endif;

        parent::persistEntity($entityManager, $entityInstance);
    }

    /**
     * @return User User
     */
    public function createEntity(string $entityFqcn): User
    {
        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        return new User(
            $this->getUser()->getBusiness(), '', '', '', '', ''
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /**
     * Encodes the password of the user.
     *
     * @param User $user The user to encode the password.
     */
    protected function _encodePassword(User $user)
    {
        $encodedPassword = $this->getUserPasswordHasher()->hashPassword(
            $user, $user->getPassword()
        );
        $user->setPassword($encodedPassword);
    }

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

}
