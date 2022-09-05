<?php

namespace App\Service;

use App\Service\Traits\MailServiceTrait;
use Exception;
use App\Entity\User;
use App\Entity\AppError;
use App\Helper\ToolsHelper;
use App\Entity\PostalAddress;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use App\Service\Interfaces\UserServiceInterface;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;

class UserService extends AppService implements UserServiceInterface
{

    /************************************************* CONSTANTS **************************************************/

    public const MAX_POSTAL_ADDRESSES = 5;

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var UserPasswordHasherInterface
     */
    protected UserPasswordHasherInterface $userPasswordHasher;

    /**
     * @var AuthenticationSuccessHandler
     */
    protected AuthenticationSuccessHandler $authenticationSuccessHandler;

    protected PasswordHasherFactoryInterface $passwordHasherFactory;

    use MailServiceTrait;

    /************************************************* CONSTRUCT **************************************************/

    /**
     * UserService construct.
     *
     * @param ManagerRegistry $doctrine Doctrine to manage the ORM.
     * @param TelegramService $telegramService Service of Telegram.
     * @param LockFactory $lockFactory The lock factory instance.
     * @param UserPasswordHasherInterface $userPasswordHasher Hasher to encode the user password.
     * @param AuthenticationSuccessHandler $authenticationSuccessHandler Handler to return a response with user's token.
     * @param PasswordHasherFactoryInterface $passwordHasherFactory The Factory PasswordHasher.
     * @param bool $testMode Boolean to set the Test Mode.
     */
    public function __construct(ManagerRegistry                $doctrine, TelegramService $telegramService,
                                LockFactory                    $lockFactory,
                                UserPasswordHasherInterface    $userPasswordHasher,
                                AuthenticationSuccessHandler   $authenticationSuccessHandler,
                                PasswordHasherFactoryInterface $passwordHasherFactory, MailService $mailService,
                                bool                           $testMode = FALSE)
    {
        parent::__construct($doctrine, $telegramService, $lockFactory, $testMode);

        $this->setUserPasswordHasher($userPasswordHasher)
            ->setAuthenticationSuccessHandler($authenticationSuccessHandler)
            ->setPasswordHasherFactoryInterface($passwordHasherFactory)
            ->setMailService($mailService);
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

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function verifyUser(int $businessID, string $email, string $token): ?string
    {
        $persisted = FALSE;
        $business = $this->getBusinessRepository()->find($businessID);
        if ($business !== NULL):
            $user = $this->getUserRepository()->findByEmail($business, $email);
            if (
                $user !== NULL &&
                md5(sprintf('%s%s', $user->getEmail(), $user->getPassword())) === $token
            ):
                $user->setIsVerified(TRUE);
                $persisted = $this->persistAndFlush($user);
            endif;
        endif;

        if (!$persisted):
            $this->registerAppError(
                ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__),
                AppError::ERROR_VERIFY_USER,
                sprintf(
                    'Ha ocurrido un error en la verificación de usuario. (Business: %s, Email: %s',
                    $businessID, $email
                )
            );
        endif;

        return $business !== NULL ? $business->getDomain() : NULL;
    }

    /**
     * @inheritDoc
     * @return bool bool
     */
    public function signup(string $email, string $password, string $phoneNumber, string $name, string $surname): bool
    {
        $method = ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__);
        $business = $this->getBusiness();
        $user = $this->getUserRepository()->findByEmail($business, $email);

        if ($user === NULL):
            $user = new User($business, $email, $password, $phoneNumber, $name, $surname);
            $encodedPassword = $this->getUserPasswordHasher()->hashPassword($user, $password);
            $user->setPassword($encodedPassword);
            $persisted = $this->persistAndFlush($user);
            if ($persisted):
                try {
                    $this->getMailService()->sendVerificationEmail($user);
                } catch (TransportExceptionInterface $e) {
                    $user->setIsVerified(TRUE);
                    $this->persistAndFlush($user);
                    $this->registerAppError(
                        $method, AppError::ERROR_SEND_MAIL,
                        'Error al enviar email de verificación de usuario.',
                        $e->getCode(), $e->getMessage(), $e->getTrace(), TRUE, FALSE
                    );
                }
            endif;
        else:
            $this->registerAppError(
                $method, Response::HTTP_CONFLICT, 'El email introducido ya existe.',
                NULL, NULL, array(), FALSE, FALSE
            );
        endif;

        return empty($this->getErrors());
    }

    /**
     * @inheritDoc
     * @return array array
     */
    public function signin(string $email, string $password): ?array
    {
        $business = $this->getBusiness();
        $user = $this->getUserRepository()->findByEmail(
            $business, $email
        );

        $token = NULL;
        if ($user !== NULL):
            if (
                $this->passwordHasherFactory->getPasswordHasher($user)->verify($user->getPassword(), $password)
                && $user->getIsVerified()
            ):
                $JSONToken = $this->getAuthenticationSuccessHandler()->handleAuthenticationSuccess($user)->getContent();
                $token = json_decode($JSONToken, TRUE);
            endif;
        endif;

        if ($user !== NULL && !$user->getIsVerified()):
            $this->registerAppError(
                ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__),
                Response::HTTP_UNAUTHORIZED,
                'Aún no has verificado la cuenta. Por favor revisa la bandeja de tu correo electrónico.',
                NULL, NULL, array(), FALSE, FALSE
            );
        elseif ($token === NULL):
            $this->registerAppError(
                ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__),
                Response::HTTP_UNAUTHORIZED, 'El email o contraseña no son correctos.',
                NULL, NULL, array(), FALSE, FALSE
            );
        endif;

        return $token;
    }


    /**
     * @inheritDoc
     * @return bool bool
     */
    public function managePostalAddress(string $name, string $address, ?string $neighborhood, string $postalCode,
                                        string $population, string $province, string $state,
                                        ?int   $postalAddressID = NULL): bool
    {
        $user = $this->getUser();
        if ($user instanceof User):
            if ($postalAddressID !== NULL):
                $postalAddress = $user->isOwnerPostalAddress($postalAddressID);
                if ($postalAddress !== NULL):
                    $postalAddress->setName($name)
                        ->setAddress($address)
                        ->setNeighborhood($neighborhood)
                        ->setPostalCode($postalCode)
                        ->setPopulation($population)
                        ->setProvince($province)
                        ->setState($state);
                    $persisted = $this->persistAndFlush($postalAddress);
                else:
                    $this->registerAppError(
                        ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__),
                        AppError::ERROR_USER_WRONG_POSTAL_ADDRESS,
                        'Error en la actualización de dirección postal: no pertenece al usuario de la sesión.'
                    );
                endif;
            elseif ($user->getPostalAddresses()->count() < static::MAX_POSTAL_ADDRESSES):
                $postalAddress = new PostalAddress(
                    $name, $address, $neighborhood, $postalCode, $population, $province, $state
                );
                $user->addPostalAddress($postalAddress);
                $persisted = $this->persistAndFlush($user);
            endif;
        else:
            $this->registerAppError_UserContextUndefined(
                ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__)
            );
        endif;

        return $persisted ?? FALSE;
    }

    /**
     * @inheritDoc
     * @return array array
     */
    public function deletePostalAddress(int $postalAddressID): bool
    {
        $method = ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__);

        $user = $this->getUser();
        if ($user instanceof User):
            $postalAddress = $user->isOwnerPostalAddress($postalAddressID);
            if ($postalAddress !== NULL):
                try {
                    $user->getPostalAddresses()->removeElement($postalAddress);
                    $this->getEntityManager()->persist($user);
                    $this->getEntityManager()->flush();
                    $this->getEntityManager()->remove($postalAddress);
                    $this->getEntityManager()->flush();
                    $deleted = TRUE;
                } catch (Exception $e) {
                    $this->registerPersistException($method, $e->getCode(), $e->getMessage(), $e->getTrace());
                }
            else:
                $this->registerAppError(
                    $method, AppError::ERROR_USER_WRONG_POSTAL_ADDRESS,
                    'Error en la actualización de dirección postal: no pertenece al usuario de la sesión.'
                );
            endif;
        else:
            $this->registerAppError_UserContextUndefined($method);
        endif;

        return $deleted ?? FALSE;
    }

    /**
     * @inheritDoc
     * @return array array
     */
    public function getUserData(): ?array
    {
        $user = $this->getUser();
        if ($user instanceof User):
            $userData = $user->__toArray();
            unset($userData['business'], $userData['roles'], $userData['password']);

            $addresses = $user->getPostalAddresses();
            $userData['postalAddresses'] = array();
            foreach ($addresses as $address):
                $userData['postalAddresses'][$address->getID()] = $address->__toArray();
            endforeach;
        else:
            $this->registerAppError_UserContextUndefined(
                ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__)
            );
        endif;

        return $userData ?? NULL;
    }

    /**
     * @inheritDoc
     * @return bool bool
     */
    public function updateUserData(string  $email, string $phoneNumber, string $name, string $surname,
                                   ?string $password = NULL): bool
    {
        $method = ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__);

        $user = $this->getUser();
        $business = $this->getBusiness();
        $userExist = $this->getUserRepository()->findByEmail($business, $email);

        if (!$user instanceof User):
            $this->registerAppError_UserContextUndefined($method);
        elseif ($userExist !== NULL && $userExist->getID() !== $user->getID()):
            $this->registerAppError(
                $method, AppError::ERROR_USER_UPDATE_EMAIL_EXIST,
                'Error en la actualización de usuario: el nuevo email indicado ya existe.'
            );
        else:
            if ($password !== NULL):
                $encodedPassword = $this->getUserPasswordHasher()->hashPassword($user, $password);
                $user->setPassword($encodedPassword);
            endif;
            $user->setEmail($email)
                ->setName($name)
                ->setSurname($surname)
                ->setPhoneNumber($phoneNumber);

            $this->persistAndFlush($user);
        endif;

        return empty($this->getErrors());
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}