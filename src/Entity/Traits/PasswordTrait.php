<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasPasswordInterface;

/**
 * Trait to implement PasswordTrait property.
 *
 * @see HasPasswordInterface
 */
trait PasswordTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", length=512, nullable=false)
     */
    protected string $password;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  PasswordTrait constructor.
     *
     * @param string $password Password to set in the entity.
     */
    public function __construct(string $password)
    {
        $this->setPassword($password);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'password' => $this->getPassword()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}