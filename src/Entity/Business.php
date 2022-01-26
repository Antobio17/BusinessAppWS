<?php

namespace App\Entity;

use App\Entity\Interfaces\BusinessInterface;
use App\Entity\Traits\DomainTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\PhoneNumberTrait;
use App\Entity\Traits\PostalAddressTrait;

/**
 *
 */
class Business extends AbstractORM implements BusinessInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    use DomainTrait {
        DomainTrait::__construct as protected __domainConstruct;
        DomainTrait::__toArray as protected __domainToArray;
    }

    use NameTrait {
        NameTrait::__construct as protected __nameConstruct;
        NameTrait::__toArray as protected __nameToArray;
    }

    use PhoneNumberTrait {
        PhoneNumberTrait::__construct as protected __phoneNumberConstruct;
        PhoneNumberTrait::__toArray as protected __phoneNumberToArray;
    }

    use PostalAddressTrait {
        PostalAddressTrait::__construct as protected __postalAddressConstruct;
        PostalAddressTrait::__toArray as protected __postalAddressToArray;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  Business constructor.
     *
     * @param string $domain Domain to set in the entity.
     * @param string $name Name to set in the entity.
     * @param string $phoneNumber PhoneNumber to set in the entity.
     * @param PostalAddress $postalAddress PostalAddress to set in the entity.
     */
    public function __construct(string $domain, string $name, string $phoneNumber, PostalAddress $postalAddress)
    {
        $this->__domainConstruct($domain);
        $this->__nameConstruct($name);
        $this->__phoneNumberConstruct($phoneNumber);
        $this->__postalAddressConstruct($postalAddress);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array_merge(
            $this->__domainToArray(),
            $this->__nameToArray(),
            $this->__phoneNumberToArray(),
            $this->__postalAddressToArray()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}