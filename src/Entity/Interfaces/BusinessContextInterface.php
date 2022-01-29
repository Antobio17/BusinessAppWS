<?php

namespace App\Entity\Interfaces;

use App\Entity\Traits\Interfaces\HasBusinessInterface;

/**
 * BusinessContext entity that provides an ID from the business.
 */
interface BusinessContextInterface extends ORMInterface, HasBusinessInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'id' => $this->>getID()
     *          'business' => $this->>getBusiness()->__toArray()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}