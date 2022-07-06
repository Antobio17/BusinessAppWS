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
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    protected ?string $neighborhood;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string|null
     */
    public function getNeighborhood(): ?string
    {
        if ($this->neighborhood !== NULL):
            $neighborhood = ToolsHelper::decrypt($this->neighborhood, getenv(static::SECRET_ENCRYPTION_TOKEN));
        endif;

        return $neighborhood ?? NULL;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setNeighborhood(?string $neighborhood): self
    {
        $this->neighborhood = $neighborhood;
        if ($neighborhood !== NULL):
            $this->neighborhood = ToolsHelper::encrypt($neighborhood, getenv(static::SECRET_ENCRYPTION_TOKEN));
        endif;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  NeighborhoodTrait constructor.
     *
     * @param string|null $neighborhood Neighborhood to set in the entity.
     */
    public function __construct(?string $neighborhood)
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