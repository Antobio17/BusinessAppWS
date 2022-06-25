<?php

namespace App\Entity;

use App\Entity\Interfaces\BusinessInterface;
use App\Entity\Traits\AmountTrait;
use App\Entity\Traits\CategoryTrait;
use App\Entity\Traits\CodeTrait;
use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\DiscountPercentTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\StockTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use App\Entity\Interfaces\ProductInterface;

/**
 * Product entity.
 *
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product extends AbstractBusinessContext implements ProductInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    use NameTrait {
        NameTrait::__construct as protected __nameConstruct;
        NameTrait::__toArray as protected __nameToArray;
    }

    use CodeTrait {
        CodeTrait::__construct as protected __codeConstruct;
        CodeTrait::__toArray as protected __codeToArray;
    }

    use DescriptionTrait {
        DescriptionTrait::__construct as protected __descriptionConstruct;
        DescriptionTrait::__toArray as protected __descriptionToArray;
    }

    use AmountTrait {
        AmountTrait::__construct as protected __priceConstruct;
        AmountTrait::__toArray as protected __priceToArray;
    }

    use StockTrait {
        StockTrait::__construct as protected __stockConstruct;
        StockTrait::__toArray as protected __stockToArray;
    }

    use CategoryTrait {
        CategoryTrait::__construct as protected __categoryConstruct;
        CategoryTrait::__toArray as protected __categoryToArray;
    }

    use DiscountPercentTrait {
        DiscountPercentTrait::__construct as protected __discountPercentConstruct;
        DiscountPercentTrait::__toArray as protected __discountPercentToArray;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  Order constructor.
     */
    public function __construct(BusinessInterface $business, string $name, string $code, string $description,
                                float $price, int $category, int $stock = 0, int $discountPercent = 0)
    {
        parent::__construct($business);

        $this->__nameConstruct($name);
        $this->__codeConstruct($code);
        $this->__descriptionConstruct($description);
        $this->__priceConstruct($price);
        $this->__stockConstruct($stock);
        $this->__categoryConstruct($category);
        $this->__discountPercentConstruct($discountPercent);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return float float
     */
    public function getPrice(): float
    {
        return $this->getAmount();
    }

    /**
     * @inheritDoc
     * @return Product Product
     */
    public function setPrice(float $price): self
    {
        return $this->setAmount($price);
    }

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
            $this->__codeToArray(),
            $this->__descriptionToArray(),
            $this->__priceToArray(),
            $this->__stockToArray(),
            $this->__categoryToArray(),
            $this->__discountPercentToArray(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}