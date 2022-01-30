<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use App\Entity\Traits\Interfaces\HasUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Trait to implement UserTrait property.
 *
 * @see HasUserInterface
 */
trait UserTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ManyToOne(targetEntity="App\Entity\User")
     * @JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected UserInterface $user;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return UserInterface UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setUser(UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  UserTrait constructor.
     */
    public function __construct(UserInterface $user)
    {
        $this->setUser($user);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'user' => $this->getUser()->getUserIdentifier(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}