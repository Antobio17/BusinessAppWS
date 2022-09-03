<?php

namespace App\Entity\Traits;

use App\Helper\ToolsHelper;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasDomainAliasInterface;

/**
 * Trait to implement DomainAlias property.
 *
 * @see HasDomainAliasInterface
 */
trait DomainAliasTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="text")
     */
    protected string $domainAlias;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getDomainAlias(): string
    {
        return $this->domainAlias;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setDomainAlias(string $domainAlias): self
    {
        $this->domainAlias = $domainAlias;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  DomainAliasTrait constructor.
     *
     * @param string $domainAlias DomainAlias of the Entity to set.
     */
    public function __construct(string $domainAlias)
    {
        $this->setDomainAlias($domainAlias);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'domainAlias' => $this->getDomainAlias()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}