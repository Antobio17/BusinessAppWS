<?php

namespace App\Service\Traits;

use App\Service\Interfaces\MailServiceInterface;
use App\Service\Traits\Interfaces\HasMailServiceInterface;

/**
 * Trait to implement Mail property.
 *
 * @see HasMailServiceInterface
 */
trait MailServiceTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var MailServiceInterface
     */
    protected MailServiceInterface $mailService;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return MailServiceInterface MailServiceInterface
     */
    public function getMailService(): MailServiceInterface
    {
        return $this->mailService;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setMailService(MailServiceInterface $mailService): self
    {
        $this->mailService = $mailService;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}