<?php

namespace App\Service\Traits;

use App\Service\Interfaces\BusinessServiceInterface;

/**
 * Trait to implement BusinessService property.
 *
 * @see HasBusinessServiceInterface
 */
trait BusinessServiceTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var BusinessServiceInterface
     */
    protected BusinessServiceInterface $businessService;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return BusinessServiceInterface BusinessServiceInterface
     */
    public function getBusinessService(): BusinessServiceInterface
    {
        return $this->businessService;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setBusinessService(BusinessServiceInterface $businessService): self
    {
        $this->businessService = $businessService;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}