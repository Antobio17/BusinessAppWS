<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait to implement IsWorkerTrait property.
 *
 * @see HasIsWorkerInterface
 */
trait IsWorkerTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="boolean", options={ "default": false })
     */
    protected bool $isWorker;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return bool bool
     */
    public function getIsWorker(): bool
    {
        return $this->isWorker;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setIsWorker(bool $isWorker): self
    {
        $this->isWorker = $isWorker;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     * IsWorkerTrait constructor.
     *
     * @param bool $isWorker Boolean to know if the user is worker.
     */
    public function __construct(bool $isWorker)
    {
        $this->setIsWorker($isWorker);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'isWorker' => $this->getIsWorker(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}