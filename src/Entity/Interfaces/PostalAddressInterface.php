<?php

namespace App\Entity\Interfaces;

use App\Entity\Traits\Interfaces\HasNameInterface;
use App\Entity\Traits\Interfaces\HasProvinceInterface;
use App\Entity\Traits\Interfaces\HasStateInterface;
use App\Entity\Traits\Interfaces\HasAddressInterface;
use App\Entity\Traits\Interfaces\HasPopulationInterface;
use App\Entity\Traits\Interfaces\HasPostalCodeInterface;
use App\Entity\Traits\Interfaces\HasNeighborhoodInterface;

/**
 * PostalAddress interface.
 */
interface PostalAddressInterface extends HasNameInterface, HasAddressInterface, HasNeighborhoodInterface,
    HasPostalCodeInterface, HasPopulationInterface, HasProvinceInterface, HasStateInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'name' => $this->getName(),
     *          'address' => $this->getAddress(),
     *          'neighborhood' => $this->getNeighborhood(),
     *          'postalCode' => $this->getPostalCode(),
     *          'population' => $this->getPopulation(),
     *          'province' => $this->getProvince(),
     *          'state' => $this->getState()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}