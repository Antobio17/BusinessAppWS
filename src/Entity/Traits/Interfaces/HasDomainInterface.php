<?php

namespace App\Entity\Traits\Interfaces;

/**
 * DomainTrait interface
 */
interface HasDomainInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Domain property of the Entity.
     *
     * @return string string
     */
    public function getDomain(): string;

    /**
     * Sets the Domain property of the Entity.
     *
     * @param string $domain Domain of the Entity to set.
     *
     * @return $this $this
     */
    public function setDomain(string $domain): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'domain' => $this->getDomain()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}