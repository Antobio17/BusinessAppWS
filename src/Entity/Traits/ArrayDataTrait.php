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
    protected string $arrayData;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function getArrayData(): array
    {
        return json_decode($this->arrayData, TRUE);
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setArrayData(array $arrayData): self
    {
        $this->arrayData = json_encode($arrayData);

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