<?php

namespace App\Service\Interfaces;

interface BusinessServiceInterface extends AppServiceInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Gets the home config of a business to render the front-end.
     *
     * @return array|null array|null
     */
    public function getBusinessHomeConfig(): ?array;

    /*********************************************** STATIC METHODS ***********************************************/

}