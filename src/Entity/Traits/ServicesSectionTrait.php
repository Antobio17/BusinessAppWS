<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasServicesSectionInterface;

/**
 * Trait to implement ServicesSectionTrait property.
 *
 * @see HasServicesSectionInterface
 */
trait ServicesSectionTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="text")
     */
    protected string $servicesData;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getServicesData(): array
    {
        return json_decode($this->servicesData, TRUE);
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setServicesData(array $data): self
    {
        $this->servicesData = json_encode($data);

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  ServicesSectionTrait constructor.
     *
     * @param array $servicesData Data related to the services section.
     */
    public function __construct(array $servicesData)
    {
        $this->setServicesData($servicesData);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'servicesData' => $this->getServicesData(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}