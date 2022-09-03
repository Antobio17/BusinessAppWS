<?php

namespace App\Service\Interfaces;

use App\Entity\AppError;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\StripeClient;
use TelegramBot\Api\BotApi;

/**
 * StripeService interface.
 */
interface StripeServiceInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the StripeClient property.
     *
     * @return StripeClient  StripeClient
     */
    public function getStripeClient(): StripeClient;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @param float $amount
     * @param string $userEmail
     * @param string $JSONProducts
     * @param string $currency
     *
     * @return PaymentIntent PaymentIntent
     * @throws ApiErrorException
     */
    public function createPaymentIntent(float $amount, string $userEmail, string $JSONProducts,
                                        string $currency = 'eur'): ?PaymentIntent;

    /*********************************************** STATIC METHODS ***********************************************/

}