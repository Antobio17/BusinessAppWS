<?php

namespace App\Entity\Interfaces;

use App\Entity\Traits\Interfaces\HasDomainInterface;

/**
 * Business interface.
 */
interface BusinessInterface extends HasDomainInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'domain' => $this->getDomain()
     *          'name' => $this->getName()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}