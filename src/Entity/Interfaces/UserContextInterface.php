<?php

namespace App\Entity\Interfaces;

use App\Entity\Traits\Interfaces\HasUserInterface;

/**
 * UserContext entity that provides an ID from the business.
 */
interface UserContextInterface extends BusinessContextInterface, HasUserInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'id' => $this->>getID()
     *          'business' => $this->>getBusiness()->__toArray()
     *          'user' => $this->>getUser()->getUserIdentifier()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}