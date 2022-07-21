<?php

namespace App\Controller;

use App\Service\Traits\BusinessServiceTrait;
use App\Service\Interfaces\BusinessServiceInterface;
use App\Controller\Interfaces\BusinessControllerInterface;

class BusinessController extends AppController implements BusinessControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    use BusinessServiceTrait;

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  BusinessController constructor.
     *
     * @param BusinessServiceInterface $businessService Service of Business.
     *
     */
    public function __construct(BusinessServiceInterface $businessService)
    {
        parent::__construct();

        $this->setBusinessService($businessService);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /************************************************** ROUTING ***************************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}