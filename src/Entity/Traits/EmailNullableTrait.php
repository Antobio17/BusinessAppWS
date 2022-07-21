<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasEmailNullableInterface;

/**
 * Trait to implement EmailNullableTrait property.
 *
 * @see HasEmailNullableInterface
 */
trait EmailNullableTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     */
    protected ?string $email;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string|null string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  EmailTrait constructor.
     *
     * @param string|null $email Email to set in the entity.
     */
    public function __construct(?string $email = NULL)
    {
        $this->setEmail($email);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'email' => $this->getEmail()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}