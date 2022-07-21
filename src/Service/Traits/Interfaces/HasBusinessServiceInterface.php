<?php

namespace App\Service\Traits\Interfaces;

use App\Service\Interfaces\BusinessServiceInterface;

/**
 * BusinessServiceTrait interface.
 */
interface HasBusinessServiceInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the property BusinessService.
     *
     * @return BusinessServiceInterface BusinessServiceInterface
     */
    public function getBusinessService(): BusinessServiceInterface;

    /**
     * Sets the property AppService.
     *
     * @param BusinessServiceInterface $appService The service of business to set.
     *
     * @return $this $this
     */
    public function setBusinessService(BusinessServiceInterface $appService): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}