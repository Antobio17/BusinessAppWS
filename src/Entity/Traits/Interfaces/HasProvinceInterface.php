<?php

namespace App\Entity\Traits\Interfaces;

/**
 * ProvinceTrait interface
 */
interface HasProvinceInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Province property of the Entity.
     *
     * @return string string
     */
    public function getProvince(): string;

    /**
     * Sets the Province property of the Entity.
     *
     * @param string $province Province of the Entity to set.
     *
     * @return $this $this
     */
    public function setProvince(string $province): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'province' => $this->getProvince()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}