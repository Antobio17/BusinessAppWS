<?php

namespace App\Entity\Traits;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Traits\Interfaces\HasWorkersInterface;

/**
 * Trait to implement WorkersTrait property.
 *
 * @see HasWorkersInterface
 */
trait WorkersTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="business", orphanRemoval=true, fetch="EXTRA_LAZY")
     */
    protected Collection $workers;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return Collection Collection
     */
    public function getWorkers(): Collection
    {
        return $this->workers;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  WorkersTrait constructor.
     *
     */
    public function __construct()
    {
        $this->workers = new ArrayCollection();
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'workers' => $this->getWorkers()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}