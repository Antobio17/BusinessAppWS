<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\HasSRCInterface;

/**
 * Trait to implement SRCTrait property.
 *
 * @see HasSRCInterface
 */
trait SRCTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ORM\Column(type="string", length=1024)
     */
    protected string $src;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    public function getSRC(): string
    {
        return $this->src;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setSRC(string $src): self
    {
        $this->src = $src;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  SRCTrait constructor.
     *
     * @param string $src SRC to set in the entity.
     */
    public function __construct(string $src)
    {
        $this->setSRC($src);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'src' => $this->getSRC()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}