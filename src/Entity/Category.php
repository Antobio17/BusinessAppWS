<?php

namespace App\Entity;

use App\Entity\Traits\NameTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategoryRepository;
use App\Entity\Traits\DescriptionTrait;
use App\Entity\Interfaces\CategoryInterface;

/**
 * Category entity.
 *
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category extends AbstractORM implements CategoryInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    use NameTrait {
        NameTrait::__construct as protected __nameConstruct;
        NameTrait::__toArray as protected __nameToArray;
    }

    use DescriptionTrait {
        DescriptionTrait::__construct as protected __descriptionConstruct;
        DescriptionTrait::__toArray as protected __descriptionToArray;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  Category constructor.
     *
     * @param string $name Name of the category.
     * @param string $description Description of the category.
     */
    public function __construct(string $name, string $description)
    {
        $this->__nameConstruct($name);
        $this->__descriptionConstruct($description);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array_merge(
            parent::__toArray(),
            $this->__nameToArray(),
            $this->__descriptionToArray(),
        );
    }

    /**
     * @inheritDoc
     * @return string string
     */
    public function __toString(): string
    {
        return $this->getName();
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}