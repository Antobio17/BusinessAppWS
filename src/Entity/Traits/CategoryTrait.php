<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasCategoryInterface;

/**
 * Trait to implement CategoryTrait property.
 *
 * @see HasCategoryInterface
 */
trait CategoryTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="integer")
     */
    protected int $category;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return int int
     */
    public function getCategory(): int
    {
        return $this->category;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setCategory(int $category): self
    {
        $this->category = $category;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  CategoryTrait constructor.
     */
    public function __construct(int $category)
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
            'category' => $this->getCategory(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}