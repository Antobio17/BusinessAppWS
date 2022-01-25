<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasDomainInterface;

/**
 * Trait to implement Domain property.
 *
 * @see HasDomainInterface
 */
trait DomainTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $domain;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setDomain(string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  DomainTrait constructor.
     */
    public function __construct(string $domain)
    {
        $this->setDomain($domain);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'domain' => $this->getDomain()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}