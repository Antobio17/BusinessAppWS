<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\EmailTrait;
use App\Repository\UserRepository;
use App\Entity\Traits\SurnameTrait;
use App\Entity\Traits\PasswordTrait;
use App\Entity\Traits\PhoneNumberTrait;
use App\Entity\Traits\PostalAddressTrait;
use Doctrine\ORM\Mapping\AttributeOverride;
use Doctrine\ORM\Mapping\AttributeOverrides;
use App\Entity\Traits\Interfaces\HasNameInterface;
use App\Entity\Traits\Interfaces\HasEmailInterface;
use App\Entity\Traits\Interfaces\HasSurnameInterface;
use App\Entity\Traits\Interfaces\HasPasswordInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Traits\Interfaces\HasPhoneNumberInterface;
use App\Entity\Traits\Interfaces\HasPostalAddressInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @AttributeOverrides({
 *      @AttributeOverride(name="name",
 *          column=@Column(
 *              name   = "name",
 *              unique = false,
 *              length = 1024
 *          )
 *      )
 * })
 */
class User extends AbstractORM implements UserInterface, PasswordAuthenticatedUserInterface, HasEmailInterface,
    HasPasswordInterface, HasPhoneNumberInterface, HasNameInterface, HasSurnameInterface,
    HasPostalAddressInterface
{

    /************************************************* CONSTANTS **************************************************/

    public const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_USER = 'ROLE_USER';

    /************************************************* PROPERTIES *************************************************/

    use EmailTrait {
        EmailTrait::__construct as protected __emailConstruct;
        EmailTrait::__toArray as protected __emailToArray;
    }

    use PasswordTrait {
        PasswordTrait::__construct as protected __passwordConstruct;
        PasswordTrait::__toArray as protected __passwordToArray;
    }

    use PhoneNumberTrait {
        PhoneNumberTrait::__construct as protected __phoneNumberConstruct;
        PhoneNumberTrait::__toArray as protected __phoneNumberToArray;
    }

    use NameTrait {
        NameTrait::__construct as protected __nameConstruct;
        NameTrait::__toArray as protected __nameToArray;
    }

    use SurnameTrait {
        SurnameTrait::__construct as protected __surnameConstruct;
        SurnameTrait::__toArray as protected __surnameToArray;
    }

    use PostalAddressTrait {
        PostalAddressTrait::__toArray as protected __postalAddressToArray;
    }

    /**
     * @ORM\Column(type="json")
     */
    protected array $roles = array();

    /************************************************* CONSTRUCT **************************************************/

    /**
     * User Construct.
     *
     * @param string $email The email of the new user.
     * @param string $password The password of the new user.
     * @param string $phoneNumber The phone number of the new user.
     * @param string $name The name of the new user.
     * @param string $surname The surname of the new user.
     * @param array $roles The roles of the new user.
     *
     */
    public function __construct(string $email, string $password, string $phoneNumber, string $name,
                                string $surname, array $roles = array())
    {
        $this->__emailConstruct($email);
        $this->__passwordConstruct($password);
        $this->__phoneNumberConstruct($phoneNumber);
        $this->__nameConstruct($name);
        $this->__surnameConstruct($surname);

        $this->setRoles(empty($roles) ? array(static::ROLE_USER) : $roles);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        # Guarantee every user at least has ROLE_USER
        $roles[] = static::ROLE_USER;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return $this->getEmail();
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array_merge(
            parent::__toArray(),
            $this->__emailToArray(),
            $this->__passwordToArray(),
            $this->__phoneNumberToArray(),
            $this->__nameToArray(),
            $this->__surnameToArray(),
            $this->__postalAddressToArray(),
            array(
                'roles' => $this->getRoles(),
            )
        );
    }
}
