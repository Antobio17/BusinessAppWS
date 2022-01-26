<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasPopulationInterface;

/**
 * Trait to implement PopulationTrait property.
 *
 * @see HasPopulationInterface
 */
trait PopulationTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $population;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getPopulation(): string
    {
        return $this->population;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setPopulation(string $population): self
    {
        $this->population = $population;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  PopulationTrait constructor.
     *
     * @param string $population Population to set in the entity.
     */
    public function __construct(string $population)
    {
        $this->setPopulation($population);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'population' => $this->getPopulation()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}