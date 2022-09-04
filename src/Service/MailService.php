<?php

namespace App\Service;

use App\Controller\AppController;
use App\Controller\UserController;
use App\Entity\User;
use App\Service\Interfaces\MailServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * Mail service.
 */
class MailService extends AbstractController implements MailServiceInterface
{

    /************************************************* CONSTANTS **************************************************/

    public const BACK_END_EMAIL_KEY_ENV = 'BACK_END_EMAIL'; # 'businessapp.ugr@gmail.com';
    public const APP_VERIFY_USER_TEMPLATE = 'mail/verify_user.html.twig';

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var MailerInterface
     */
    protected MailerInterface $mailer;

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  MailService constructor.
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return MailerInterface MailerInterface
     */
    public function getMailer(): MailerInterface
    {
        return $this->mailer;
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @throws TransportExceptionInterface
     */
    public function sendVerificationEmail(User $user)
    {
        $html = $this->renderView(static::APP_VERIFY_USER_TEMPLATE, array(
            'url' => sprintf(
                '%s?email=%s&business=%d&token=%s',
                sprintf(
                    '%s%s',
                    getenv(AppController::BACK_END_URL_KEY_ENV), UserController::PATH_VERIFY_USER
                ),
                $user->getEmail(), $user->getBusiness()->getID(),
                md5(sprintf('%s%s', $user->getEmail(), $user->getPassword()))
            ),
            'businessName' => $user->getBusiness()->getName(),
            'userName' => $user->getName()
        ));

        $this->_sendEmail(
            getenv(static::BACK_END_EMAIL_KEY_ENV), $user->getEmail(), 'Verificación de cuenta', $html
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /**
     * Method to send an email from the symfony mailer service.
     *
     * @param string $from The from value of the email.
     * @param string $to The to value of the email.
     * @param string $subject The subject of the email.
     * @param string $html The body of the email.
     *
     * @throws TransportExceptionInterface
     */
    protected function _sendEmail(string $from, string $to, string $subject, string $html)
    {
        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->html($html);

        $this->getMailer()->send($email);
    }

    /*********************************************** STATIC METHODS ***********************************************/

}