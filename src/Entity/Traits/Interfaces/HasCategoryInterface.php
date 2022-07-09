<?php

namespace App\Entity\Traits\Interfaces;

use App\Entity\Interfaces\CategoryInterface;

/**
 * CategoryTrait interface
 */
interface HasCategoryInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Category property.
     *
     * @return CategoryInterface CategoryInterface
     */
    public function getCategory(): CategoryInterface;

    /**
     * Sets the Category property.
     *
     * @param CategoryInterface $category The Category to be set.
     *
     * @return $this $this
     */
    public function setCategory(CategoryInterface $category): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'category' => $this->getCategory()->__toArray()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}