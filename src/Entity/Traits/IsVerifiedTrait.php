<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait to implement IsVerifiedTrait property.
 *
 * @see HasIsVerifiedInterface
 */
trait IsVerifiedTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="boolean", options={ "default": false })
     */
    protected bool $isVerified;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return bool bool
     */
    public function getIsVerified(): bool
    {
        return $this->isVerified;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     * IsVerifiedTrait constructor.
     *
     * @param bool $isVerified Boolean to know if the user is Verified.
     */
    public function __construct(bool $isVerified)
    {
        $this->setIsVerified($isVerified);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'isVerified' => $this->getIsVerified(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}