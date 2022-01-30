<?php

namespace App\Entity;

use App\Entity\Traits\UserTrait;
use App\Entity\Interfaces\BusinessInterface;
use App\Entity\Interfaces\UserContextInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * AbstractUserContext entity.
 */
abstract class AbstractUserContext extends AbstractBusinessContext implements UserContextInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    use UserTrait {
        UserTrait::__construct as protected __userConstruct;
        UserTrait::__toArray as protected __userToArray;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     * UserContext construct.
     *
     * @param UserInterface $user The user to set in the entity.
     *
     */
    public function __construct(BusinessInterface $business, UserInterface $user)
    {
        parent::__construct($business);

        $this->__userConstruct($user);
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
            parent::__toArray(),
            $this->__userToArray()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}