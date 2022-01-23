<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User extends AbstractORM implements UserInterface, PasswordAuthenticatedUserInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="string", length=180, unique=true, nullable=false)
     */
    protected string $email;

    /**
     * @ORM\Column(type="json")
     */
    protected array $roles;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", length=512, nullable=false)
     */
    protected string $password;

    /************************************************* CONSTRUCT **************************************************/

    public function __construct(string $email, string $password, array $roles)
    {
        $this->setEmail($email)
            ->setPassword($password)
            ->setRoles($roles);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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
}
