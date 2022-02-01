<?php

namespace App\Entity\Traits;

use App\Helper\ToolsHelper;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasEmailInterface;

/**
 * Trait to implement EmailTrait property.
 *
 * @see HasEmailInterface
 */
trait EmailTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="string", length=512, unique=true, nullable=false)
     */
    protected string $email;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  EmailTrait constructor.
     *
     * @param string $email Email to set in the entity.
     */
    public function __construct(string $email)
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