<?php

namespace App\Service\Traits;

use App\Service\Interfaces\StripeServiceInterface;
use App\Service\Traits\Interfaces\HasStripeServiceInterface;

/**
 * Trait to implement Stripe property.
 *
 * @see HasStripeServiceInterface
 */
trait StripeServiceTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var StripeServiceInterface
     */
    protected StripeServiceInterface $stripeService;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return StripeServiceInterface StripeServiceInterface
     */
    public function getStripeService(): StripeServiceInterface
    {
        return $this->stripeService;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setStripeService(StripeServiceInterface $stripeService): self
    {
        $this->stripeService = $stripeService;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}