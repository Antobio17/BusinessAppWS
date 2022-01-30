<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Trait to implement WorkerTrait property.
 *
 * @see HasWorkerInterface
 */
trait WorkerTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ManyToOne(targetEntity="App\Entity\User")
     * @JoinColumn(name="worker_id", referencedColumnName="id", nullable=false)
     */
    protected UserInterface $worker;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return UserInterface UserInterface
     */
    public function getWorker(): UserInterface
    {
        return $this->worker;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setWorker(UserInterface $worker): self
    {
        $this->worker = $worker;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  WorkerTrait constructor.
     */
    public function __construct(UserInterface $worker)
    {
        $this->setWorker($worker);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'worker' => $this->getWorker()->getUserIdentifier(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}