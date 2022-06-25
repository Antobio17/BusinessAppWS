<?php

namespace App\Entity\Traits;

use App\Helper\ToolsHelper;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasDescriptionInterface;

/**
 * Trait to implement Description property.
 *
 * @see HasDescriptionInterface
 */
trait DescriptionTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="text")
     */
    protected string $description;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  DescriptionTrait constructor.
     *
     * @param string $description Description of the Entity to set.
     */
    public function __construct(string $description)
    {
        $this->setDescription($description);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'description' => $this->getDescription()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}