<?php

namespace App\Entity\Traits;

use App\Entity\Traits\AltTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\WidthTrait;
use App\Entity\Traits\HeightTrait;
use App\Repository\ImageRepository;
use App\Entity\Traits\Interfaces\HasImageInterface;

/**
 * Image trait.
 *
 * @see HasImageInterface
 */
trait ImageTrait
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    use NameTrait {
        NameTrait::__construct as protected __nameConstruct;
        NameTrait::__toArray as protected __nameToArray;
    }

    use WidthTrait {
        WidthTrait::__construct as protected __widthConstruct;
        WidthTrait::__toArray as protected __widthToArray;
    }

    use HeightTrait {
        HeightTrait::__construct as protected __heightConstruct;
        HeightTrait::__toArray as protected __heightToArray;
    }

    use AltTrait {
        AltTrait::__construct as protected __altConstruct;
        AltTrait::__toArray as protected __altToArray;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  Image constructor.
     *
     * @param string $name Name of the image.
     * @param int $width Width of the image.
     * @param int $height Height od the image.
     * @param string $alt Alt of the image.
     */
    public function __construct(string $name, int $width, int $height, string $alt)
    {
        $this->__nameConstruct($name);
        $this->__widthConstruct($width);
        $this->__heightConstruct($height);
        $this->__altConstruct($alt);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array_merge(
            $this->__nameToArray(),
            $this->__widthToArray(),
            $this->__heightToArray(),
            $this->__altToArray(),
        );
    }

    /**
     * @inheritDoc
     * @return string string
     */
    public function __toString(): string
    {
        return $this->getName();
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/
}