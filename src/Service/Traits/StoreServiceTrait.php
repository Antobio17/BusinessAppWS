<?php

namespace App\Service\Traits;

use App\Service\Interfaces\StoreServiceInterface;
use App\Service\Traits\Interfaces\HasStoreServiceInterface;

/**
 * Trait to implement Store property.
 *
 * @see HasStoreServiceInterface
 */
trait StoreServiceTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var StoreServiceInterface
     */
    protected StoreServiceInterface $storeService;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return StoreServiceInterface StoreServiceInterface
     */
    public function getStoreService(): StoreServiceInterface
    {
        return $this->storeService;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setStoreService(StoreServiceInterface $storeService): self
    {
        $this->storeService = $storeService;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}