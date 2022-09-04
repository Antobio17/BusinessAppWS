<?php

namespace App\Entity\Traits\Interfaces;

/**
 * DomainAliasTrait interface
 */
interface HasDomainAliasInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the DomainAlias property of the Entity.
     *
     * @return string string
     */
    public function getDomainAlias(): string;

    /**
     * Sets the DomainAlias property of the Entity.
     *
     * @param string|null $domainAlias DomainAlias of the Entity to set.
     *
     * @return $this $this
     */
    public function setDomainAlias(?string $domainAlias): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'domainAlias' => $this->getDomainAlias()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}