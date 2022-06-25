<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasStockInterface;

/**
 * Trait to implement StockTrait property.
 *
 * @see HasStockInterface
 */
trait StockTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="integer", options={ "default": 0 })
     */
    protected int $stock;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return int int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  StockTrait constructor.
     */
    public function __construct(int $stock = 0)
    {
        $this->setStock($stock);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'stock' => $this->getStock(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}