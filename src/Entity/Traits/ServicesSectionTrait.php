<?php

namespace App\Entity\Traits;

use App\Entity\BusinessService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasServicesSectionInterface;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * Trait to implement ServicesSectionTrait property.
 *
 * @see HasServicesSectionInterface
 */
trait ServicesSectionTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * One Business has many shifts.
     *
     * @OneToMany(targetEntity="App\Entity\BusinessService", mappedBy="homeConfig", cascade={"all"})
     */
    protected Collection $businessServices;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return BusinessService[]|Collection BusinessService[]|Collection
     */
    public function getBusinessServices(): Collection
    {
        return $this->businessServices;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function addBusinessService(BusinessService $businessServices): self
    {
        $this->businessServices->add($businessServices);

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  ServicesSectionTrait constructor.
     *
     */
    public function __construct()
    {
        $this->businessServices = new ArrayCollection();
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function getBusinessServicesAsArray(): array
    {
        foreach ($this->getBusinessServices() as $service):
            $businessServices[] = $service->__toArray();
        endforeach;

        return $businessServices ?? array();
    }

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            $this->getBusinessServicesAsArray(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}