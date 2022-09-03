<?php

namespace App\Service\Traits\Interfaces;

use App\Service\Interfaces\AppointmentServiceInterface;
use App\Service\Interfaces\StripeServiceInterface;

/**
 * StripeServiceTrait interface.
 */
interface HasStripeServiceInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the property StripeService.
     *
     * @return StripeServiceInterface StripeServiceInterface
     */
    public function getStripeService(): StripeServiceInterface;

    /**
     * Sets the property StripeService.
     *
     * @param StripeServiceInterface $stripeService The service of Stripe to set.
     *
     * @return $this $this
     */
    public function setStripeService(StripeServiceInterface $stripeService): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}