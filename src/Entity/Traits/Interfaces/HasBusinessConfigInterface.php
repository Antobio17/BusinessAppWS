<?php

namespace App\Entity\Traits\Interfaces;

/**
 * BusinessConfig interface
 */
interface HasBusinessConfigInterface extends HasOpensAtInterface, HasClosesAtInterface, HasAppointmentDurationInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     *
     *      Returns array(
     *          'businessConfig' => $this->getBusinessConfig()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}