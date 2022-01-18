<?php

namespace App\Controller\Interfaces;

use App\Service\Interfaces\AppServiceInterface;

interface AppControllerInterface
{

    /************************************************** ROUTING ***************************************************/

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the instance of AppService.
     *
     * @return AppServiceInterface AppServiceInterface
     */
    public function getAppService(): AppServiceInterface;

    /**
     * Sets an instance of AppService in the AppController.
     *
     * @param AppServiceInterface $appService Service of App.
     *
     * @return $this $this
     */
    public function setAppService(AppServiceInterface $appService): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}