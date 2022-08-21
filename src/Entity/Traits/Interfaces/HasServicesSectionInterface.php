<?php

namespace App\Entity\Traits\Interfaces;

use App\Entity\BusinessService;
use Doctrine\Common\Collections\Collection;

/**
 * ServicesSectionTrait interface
 */
interface HasServicesSectionInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the business services' collection of the Entity.
     *
     * @return BusinessService[]|Collection BusinessService[]|Collection
     */
    public function getBusinessServices(): Collection;

    /**
     * Add a service to property collection of the Entity.
     *
     * @param BusinessService $businessServices The image to set.
     *
     * @return $this $this
     */
    public function addBusinessService(BusinessService $businessServices): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Gets the business services as an array.
     *
     * @return array array
     */
    public function getBusinessServicesAsArray(): array;

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'businessServices' => $this->getSectionData()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}