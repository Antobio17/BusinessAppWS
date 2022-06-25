<?php

namespace App\Entity\Traits\Interfaces;

/**
 * CategoryTrait interface
 */
interface HasCategoryInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Category property.
     *
     * @return int int
     */
    public function getCategory(): int;

    /**
     * Sets the Category property.
     *
     * @param int $category The Category to be set.
     *
     * @return $this $this
     */
    public function setCategory(int $category): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'category' => $this->>getCategory()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}