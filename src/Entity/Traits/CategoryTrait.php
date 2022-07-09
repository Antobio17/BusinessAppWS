<?php

namespace App\Entity\Traits;

use App\Entity\Category;
use App\Entity\Interfaces\CategoryInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasCategoryInterface;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Trait to implement Category property.
 *
 * @see HasCategoryInterface
 */
trait CategoryTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ManyToOne(targetEntity="App\Entity\Category")
     * @JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     */
    protected CategoryInterface $category;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return CategoryInterface CategoryInterface
     */
    public function getCategory(): CategoryInterface
    {
        return $this->category;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setCategory(CategoryInterface $category): self
    {
        $this->category = $category;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  CategoryTrait constructor.
     */
    public function __construct(CategoryInterface $category)
    {
        $this->setCategory($category);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'category' => $this->getCategory()->__toArray(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}