<?php

namespace App\Entity\Traits\Interfaces;

/**
 * ArrayDataTrait interface
 */
interface HasArrayDataInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the property ArrayData.
     *
     * @return array array
     */
    public function getArrayData(): array;

    /**
     * Sets the property ArrayData.
     *
     * @param array $arrayData The array data to set.
     *
     * @return $this $this
     */
    public function setArrayData(array $arrayData): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns the property ArrayData.
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}