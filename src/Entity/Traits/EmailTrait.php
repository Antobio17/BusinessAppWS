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
        return ToolsHelper::decrypt($this->email, getenv(static::SECRET_ENCRYPTION_TOKEN));
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setEmail(string $email): self
    {
        $this->email = ToolsHelper::encrypt($email, getenv(static::SECRET_ENCRYPTION_TOKEN));

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