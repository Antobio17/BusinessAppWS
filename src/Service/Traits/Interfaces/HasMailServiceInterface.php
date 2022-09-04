<?php

namespace App\Service\Traits\Interfaces;

use App\Service\Interfaces\MailServiceInterface;

/**
 * MailServiceTrait interface.
 */
interface HasMailServiceInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the property MailService.
     *
     * @return MailServiceInterface MailServiceInterface
     */
    public function getMailService(): MailServiceInterface;

    /**
     * Sets the property MailService.
     *
     * @param MailServiceInterface $mailService The service of Mail to set.
     *
     * @return $this $this
     */
    public function setMailService(MailServiceInterface $mailService): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}