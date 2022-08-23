<?php

namespace App\Entity;

use App\Entity\Interfaces\BusinessInterface;
use App\Entity\Interfaces\PostalAddressInterface;
use App\Entity\Traits\BusinessNullableTrait;
use App\Entity\Traits\Interfaces\HasBusinessNullableInterface;
use App\Entity\Traits\EmailNullableTrait;
use App\Entity\Traits\Interfaces\HasEmailNullableInterface;
use App\Entity\Traits\Interfaces\HasIsWorkerInterface;
use App\Entity\Traits\IsWorkerTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use App\Entity\Traits\NameTrait;
use App\Repository\UserRepository;
use App\Entity\Traits\SurnameTrait;
use App\Entity\Traits\PasswordTrait;
use App\Entity\Traits\PhoneNumberTrait;
use Doctrine\ORM\Mapping\AttributeOverride;
use Doctrine\ORM\Mapping\AttributeOverrides;
use App\Entity\Traits\Interfaces\HasNameInterface;
use App\Entity\Traits\Interfaces\HasSurnameInterface;
use App\Entity\Traits\Interfaces\HasPasswordInterface;
use Doctrine\ORM\Mapping\JoinTable;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Traits\Interfaces\HasPhoneNumberInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="user", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="identifying_tuple", columns={"email", "phone_number", "business_id"})
 * })
 * @AttributeOverrides({
 *      @AttributeOverride(name="email",
 *          column=@Column(
 *              name   = "email",
 *              unique = false,
 *              length = 1024,
 *              nullable = true
 *          )
 *      ),
 *     @AttributeOverride(name="phoneNumber",
 *          column=@Column(
 *              unique = false,
 *          )
 *      ),
 *     @AttributeOverride(name="name",
 *          column=@Column(
 *              name   = "name",
 *              unique = false,
 *              length = 1024
 *          )
 *      )
 * })
 */
class User extends AbstractORM implements UserInterface, HasBusinessNullableInterface,
    PasswordAuthenticatedUserInterface, HasEmailNullableInterface, HasPasswordInterface, HasPhoneNumberInterface,
    HasNameInterface, HasSurnameInterface, HasIsWorkerInterface
{

    /************************************************* CONSTANTS **************************************************/

    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_WORKER = 'ROLE_WORKER';
    public const ROLE_USER = 'ROLE_USER';

    /************************************************* PROPERTIES *************************************************/

    use BusinessNullableTrait {
        BusinessNullableTrait::__construct as protected __businessConstruct;
        BusinessNullableTrait::__toArray as protected __businessToArray;
    }

    use EmailNullableTrait {
        EmailNullableTrait::__construct as protected __emailConstruct;
        EmailNullableTrait::__toArray as protected __emailToArray;
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

    use IsWorkerTrait {
        IsWorkerTrait::__construct as protected __isWorkerConstruct;
        IsWorkerTrait::__toArray as protected __isWorkerToArray;
    }

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PostalAddress", cascade={"all"})
     * @JoinTable(name="postal_addresses_users",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="postal_address_id", referencedColumnName="id")}
     * )
     */
    protected Collection $postalAddresses;

    /**
     * @ORM\Column(type="json")
     */
    protected array $roles = array();

    /************************************************* CONSTRUCT **************************************************/

    /**
     * User Construct.
     *
     * @param BusinessInterface|null $business Business to which the user belongs.
     * @param string|null $email The email of the new user.
     * @param string $password The password of the new user.
     * @param string $phoneNumber The phone number of the new user.
     * @param string $name The name of the new user.
     * @param string $surname The surname of the new user.
     * @param array $roles The roles of the new user.
     * @param bool $isWorker If the user is a worker.
     */
    public function __construct(?BusinessInterface $business, ?string $email, string $password, string $phoneNumber,
                                string             $name, string $surname, array $roles = array(),
                                bool $isWorker = FALSE)
    {
        $this->__businessConstruct($business);
        $this->__emailConstruct($email);
        $this->__passwordConstruct($password);
        $this->__phoneNumberConstruct($phoneNumber);
        $this->__nameConstruct($name);
        $this->__surnameConstruct($surname);
        $this->__isWorkerConstruct($isWorker);

        $this->setRoles(empty($roles) ? array(static::ROLE_USER) : $roles);

        $this->postalAddresses = new ArrayCollection();
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
        return $this->getEmail() ?? $this->getPhoneNumber();
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
     * Gets the collection of postal addresses of the user.
     *
     * @return Collection|PostalAddressInterface[] Collection|PostalAddressInterface[]
     */
    public function getPostalAddresses(): Collection
    {
        return $this->postalAddresses;
    }

    /**
     * Add a new postal address to the user.
     *
     * @param PostalAddressInterface $postalAddress The new postal address to add.
     *
     * @return $this $this
     */
    public function addPostalAddress(PostalAddressInterface $postalAddress): self
    {
        $this->getPostalAddresses()->add($postalAddress);

        return $this;
    }

    /**
     * Checks if the ID of the postal address belongs to the user.
     *
     * @param int $postalAddressID ID os the postal address to check.
     *
     * @return PostalAddressInterface|null PostalAddressInterface|null
     */
    public function isOwnerPostalAddress(int $postalAddressID): ?PostalAddressInterface
    {
        foreach ($this->getPostalAddresses() as $postalAddress):
            if ($postalAddress->getID() === $postalAddressID):
                $result = $postalAddress;
                break;
            endif;
        endforeach;

        return $result ?? NULL;
    }

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array_merge(
            parent::__toArray(),
            $this->__businessToArray(),
            $this->__emailToArray(),
            $this->__passwordToArray(),
            $this->__phoneNumberToArray(),
            $this->__nameToArray(),
            $this->__surnameToArray(),
            $this->__isWorkerToArray(),
            array(
                'roles' => $this->getRoles(),
            )
        );
    }

    /**
     * Returns the entity in a string identifier.
     *
     * @return string string
     */
    public function __toString(): string
    {
        return $this->getEmail() ?? $this->getPhoneNumber();
    }

}
