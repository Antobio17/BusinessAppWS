<?php

namespace App\Entity\Traits;

use App\Helper\ToolsHelper;
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
     * @ORM\Column(type="string", length=1024)
     */
    protected string $population;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getPopulation(): string
    {
        return ToolsHelper::decrypt($this->population, getenv(static::SECRET_ENCRYPTION_TOKEN));
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setPopulation(string $population): self
    {
        $this->population = ToolsHelper::encrypt($population, getenv(static::SECRET_ENCRYPTION_TOKEN));

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