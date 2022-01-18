<?php

namespace App\Entity\Traits;

use App\Helper\ToolsHelper;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasArrayDataInterface;

/**
 * Trait to implement ArrayData property.
 *
 * @see HasArrayDataInterface
 */
trait ArrayDataTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private string $arrayData;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function getArrayData(): array
    {
        return ToolsHelper::getStringAsArray($this->arrayData);
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setArrayData(array $arrayData): self
    {
        $this->arrayData = serialize($arrayData);

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  ArrayDataTrait constructor.
     */
    public function __construct(array $arrayData)
    {
        $this->setArrayData($arrayData);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return $this->getArrayData();
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}