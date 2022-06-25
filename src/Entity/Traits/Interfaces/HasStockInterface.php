<?php

namespace App\Entity\Traits\Interfaces;

/**
 * StockTrait interface
 */
interface HasStockInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Stock property.
     *
     * @return int int
     */
    public function getStock(): int;

    /**
     * Sets the Stock property.
     *
     * @param int $stock The Stock to be set.
     *
     * @return $this $this
     */
    public function setStock(int $stock): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'stock' => $this->>getStock()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}