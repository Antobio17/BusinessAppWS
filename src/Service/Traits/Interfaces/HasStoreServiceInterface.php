<?php

namespace App\Service\Traits\Interfaces;

use App\Service\Interfaces\AppointmentServiceInterface;
use App\Service\Interfaces\StoreServiceInterface;

/**
 * StoreServiceTrait interface.
 */
interface HasStoreServiceInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the property StoreService.
     *
     * @return StoreServiceInterface StoreServiceInterface
     */
    public function getStoreService(): StoreServiceInterface;

    /**
     * Sets the property StoreService.
     *
     * @param StoreServiceInterface $storeService The service of Store to set.
     *
     * @return $this $this
     */
    public function setStoreService(StoreServiceInterface $storeService): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}