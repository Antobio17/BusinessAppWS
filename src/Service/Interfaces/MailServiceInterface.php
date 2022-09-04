<?php

namespace App\Service\Interfaces;

use App\Entity\User;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

/**
 * MailService interface.
 */
interface MailServiceInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Mailer property of the service.
     *
     * @return MailerInterface MailerInterface
     */
    public function getMailer(): MailerInterface;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Facade to send the verification email to a new user.
     * Its throw an exception if the delivery fails.
     *
     * @param User $user The user to send the email.
     *
     * @throws TransportExceptionInterface
     */
    public function sendVerificationEmail(User $user);

    /*********************************************** STATIC METHODS ***********************************************/

}