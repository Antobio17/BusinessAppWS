<?php

namespace App\Entity;

use App\Entity\Traits\NameTrait;
use App\Entity\Traits\StateTrait;
use App\Entity\Traits\AddressTrait;
use App\Entity\Traits\ProvinceTrait;
use App\Entity\Traits\PopulationTrait;
use App\Entity\Traits\PostalCodeTrait;
use App\Entity\Traits\NeighborhoodTrait;
use App\Entity\Interfaces\PostalAddressInterface;

/**
 * Entity PostalAddress.
 */
class PostalAddress extends AbstractORM implements PostalAddressInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    use NameTrait {
        NameTrait::__construct as protected __nameConstruct;
        NameTrait::__toArray as protected __nameToArray;
    }

    use AddressTrait {
        AddressTrait::__construct as protected __addressConstruct;
        AddressTrait::__toArray as protected __addressToArray;
    }

    use NeighborhoodTrait {
        NeighborhoodTrait::__construct as protected __neighborhoodConstruct;
        NeighborhoodTrait::__toArray as protected __neighborhoodToArray;
    }

    use PostalCodeTrait {
        PostalCodeTrait::__construct as protected __postalCodeConstruct;
        PostalCodeTrait::__toArray as protected __postalCodeToArray;
    }

    use PopulationTrait {
        PopulationTrait::__construct as protected __populationConstruct;
        PopulationTrait::__toArray as protected __populationToArray;
    }

    use ProvinceTrait {
        ProvinceTrait::__construct as protected __provinceConstruct;
        ProvinceTrait::__toArray as protected __provinceToArray;
    }

    use StateTrait {
        StateTrait::__construct as protected __stateConstruct;
        StateTrait::__toArray as protected __stateToArray;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  PostalAddress constructor.
     *
     * @param string $name Name to set in the entity.
     * @param string $address Address to set in the entity.
     * @param string $neighborhood Neighborhood to set in the entity.
     * @param string $postalCode PostalCode to set in the entity.
     * @param string $population Population to set in the entity.
     * @param string $province Province to set in the entity.
     * @param string $state State to set in the entity.
     */
    public function __construct(string $name, string $address, string $neighborhood, string $postalCode,
                                string $population, string $province, string $state)
    {
        $this->__nameConstruct($name);
        $this->__addressConstruct($address);
        $this->__neighborhoodConstruct($neighborhood);
        $this->__postalCodeConstruct($postalCode);
        $this->__populationConstruct($population);
        $this->__provinceConstruct($province);
        $this->__stateConstruct($state);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array_merge(
            $this->__nameToArray(),
            $this->__addressToArray(),
            $this->__neighborhoodToArray(),
            $this->__postalCodeToArray(),
            $this->__populationToArray(),
            $this->__provinceToArray(),
            $this->__stateToArray()
        );
    }

}