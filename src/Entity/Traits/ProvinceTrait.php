<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasProvinceInterface;

/**
 * Trait to implement ProvinceTrait property.
 *
 * @see HasProvinceInterface
 */
trait ProvinceTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $province;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getProvince(): string
    {
        return $this->province;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setProvince(string $province): self
    {
        $this->province = $province;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  ProvinceTrait constructor.
     *
     * @param string $province Province to set in the entity.
     */
    public function __construct(string $province)
    {
        $this->setProvince($province);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'province' => $this->getProvince()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}