<?php

namespace App\Entity\Interfaces;

/**
 * Abstract ORM entity that adds a self-generated ID to descendant entities.
 */
interface ORMInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the ID property of the User.
     *
     *      returns int: the ID of the user.
     *
     * @return int|null int|null
     */
    public function getID(): ?int;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Method to get the trait in array format.
     *
     *      returns array(
     *                  'id' => $id
     *              )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}