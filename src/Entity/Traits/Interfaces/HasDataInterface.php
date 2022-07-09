<?php

namespace App\Entity\Traits\Interfaces;

/**
 * DataTrait interface
 */
interface HasDataInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Data property of the Entity.
     *
     * @return array array
     */
    public function getData(): array;

    /**
     * Sets the Data property of the Entity.
     *
     * @param array $data Data of the Entity to set.
     *
     * @return $this $this
     */
    public function setData(array $data): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'data' => $this->getData()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}