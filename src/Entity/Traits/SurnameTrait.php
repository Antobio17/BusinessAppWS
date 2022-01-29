<?php

namespace App\Entity\Traits;

use App\Helper\ToolsHelper;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasSurnameInterface;

/**
 * Trait to implement SurnameTrait property.
 *
 * @see HasSurnameInterface
 */
trait SurnameTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="string", length=1024, nullable=false)
     */
    protected string $surname;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getSurname(): string
    {
        return ToolsHelper::decrypt($this->surname, getenv(static::SECRET_ENCRYPTION_TOKEN));
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setSurname(string $surname): self
    {
        $this->surname = ToolsHelper::encrypt($surname, getenv(static::SECRET_ENCRYPTION_TOKEN));

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  SurnameTrait constructor.
     *
     * @param string $surname Surname to set in the entity.
     */
    public function __construct(string $surname)
    {
        $this->setSurname($surname);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'surname' => $this->getSurname()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}