<?php

namespace App\Entity;

use App\Entity\Interfaces\AppointmentInterface;
use App\Entity\Interfaces\BusinessInterface;
use App\Entity\Traits\StatusTrait;

/**
 *
 */
class Appointment extends AbstractBusinessContext implements AppointmentInterface
{

    /************************************************* CONSTANTS **************************************************/

    public const STATUS_PENDING = 0;
    public const STATUS_CANCELLED = 1;
    public const STATUS_DONE = 2;

    /************************************************* PROPERTIES *************************************************/


    use StatusTrait {
        StatusTrait::__construct as protected __statusConstruct;
        StatusTrait::__toArray as protected __statusToArray;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  Appointment constructor.
     */
    public function __construct(BusinessInterface $business, int $status = 0)
    {
        parent::__construct($business);

        $this->__statusConstruct($status);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}