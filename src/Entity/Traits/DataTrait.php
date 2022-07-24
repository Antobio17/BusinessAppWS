<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasDomainInterface;

/**
 * Trait to implement Domain property.
 *
 * @see HasDomainInterface
 */
trait DataTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="text")
     */
    protected string $data;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function getData(): array
    {
        return json_decode($this->data, TRUE);
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setData(array $data): self
    {
        $this->data = json_encode($data);

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  DataTrait constructor.
     *
     * @param array $data Array of data.
     */
    public function __construct(array $data = array())
    {
        $this->setData($data);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'data' => $this->getData()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}