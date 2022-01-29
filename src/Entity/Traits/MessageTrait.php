<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasMessageInterface;

/**
 * Trait to implement Message property.
 *
 * @see HasMessageInterface
 */
trait MessageTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var string
     * @ORM\Column(type="string", length=1024)
     */
    protected string $message;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  MessageTrait constructor.
     */
    public function __construct(string $message)
    {
        $this->setMessage($message);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'message' => $this->getMessage(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}