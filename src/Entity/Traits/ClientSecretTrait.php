<?php

namespace App\Entity\Traits;

use App\Helper\ToolsHelper;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasClientSecretInterface;

/**
 * Trait to implement ClientSecret property.
 *
 * @see HasClientSecretInterface
 */
trait ClientSecretTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="string", length=1024, unique=true, nullable=true)
     */
    protected ?string $clientSecret;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string|null string|null
     */
    public function getClientSecret(): ?string
    {
        if ($this->clientSecret !== NULL):
            $encryptedCS = ToolsHelper::decrypt($this->clientSecret, getenv(static::SECRET_ENCRYPTION_TOKEN));
        endif;

        return $encryptedCS ?? NULL;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setClientSecret(?string $clientSecret): self
    {
        if ($clientSecret !== NULL):
            $encryptedCS = ToolsHelper::encrypt($clientSecret, getenv(static::SECRET_ENCRYPTION_TOKEN));
        endif;
        $this->clientSecret = $encryptedCS ?? NULL;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  ClientSecretTrait constructor.
     *
     * @param string|null $clientSecret ClientSecret of the Entity to set.
     */
    public function __construct(?string $clientSecret)
    {
        $this->setClientSecret($clientSecret);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'clientSecret' => $this->getClientSecret()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}