<?php

namespace App\Entity\Traits;

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
     * @ORM\Column(type="string", length=180, unique=true, nullable=false)
     */
    protected string $surname;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

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