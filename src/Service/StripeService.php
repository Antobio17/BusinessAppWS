<?php

namespace App\Service;

use Exception;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\StripeClient;
use App\Service\Interfaces\StripeServiceInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Stripe service.
 */
class StripeService implements StripeServiceInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var StripeClient
     */
    protected StripeClient $stripeClient;

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  StripeService constructor.
     */
    public function __construct(ParameterBagInterface $parameterBag)
    {
        /** @noinspection MissingService */
        $this->stripeClient = new StripeClient ($parameterBag->get('app.stripe_client_secret_key'));
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return StripeClient  StripeClient
     */
    public function getStripeClient(): StripeClient
    {
        return $this->stripeClient;
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return PaymentIntent|null PaymentIntent|null
     * @throws ApiErrorException
     */
    public function createPaymentIntent(float $amount, string $userEmail, string $JSONProducts,
                                        string $currency = 'eur'): ?PaymentIntent
    {
        return $paymentIntent = $this->getStripeClient()->paymentIntents->create(array(
                'amount' => round($amount * 100),
                'currency' => $currency,
                'receipt_email' => $userEmail,
                'description' => $JSONProducts,
            ));
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}