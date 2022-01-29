<?php

namespace App\Entity\Traits;

use App\Helper\ToolsHelper;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasNeighborhoodInterface;

/**
 * Trait to implement NeighborhoodTrait property.
 *
 * @see HasNeighborhoodInterface
 */
trait NeighborhoodTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="string", length=1024)
     */
    protected string $neighborhood;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getNeighborhood(): string
    {
        return ToolsHelper::decrypt($this->neighborhood, getenv(static::SECRET_ENCRYPTION_TOKEN));
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setNeighborhood(string $neighborhood): self
    {
        $this->neighborhood = ToolsHelper::encrypt($neighborhood, getenv(static::SECRET_ENCRYPTION_TOKEN));

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  NeighborhoodTrait constructor.
     *
     * @param string $neighborhood Neighborhood to set in the entity.
     */
    public function __construct(string $neighborhood)
    {
        $this->setNeighborhood($neighborhood);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'neighborhood' => $this->getNeighborhood()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}