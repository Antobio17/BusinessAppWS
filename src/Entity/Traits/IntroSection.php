<?php

namespace App\Entity\Traits;

use App\Entity\Traits\Interfaces\HasIntroSectionInterface;

/**
 * Trait to implement IntroSectionTrait property.
 *
 * @see HasIntroSectionInterface
 */
trait IntroSection
{

    /************************************************* PROPERTIES *************************************************/

    use SRCTrait {
        SRCTrait::__construct as protected __srcConstruct;
        SRCTrait::__toArray as protected __srcToArray;
    }

    use NameTrait {
        NameTrait::__construct as protected __nameConstruct;
        NameTrait::__toArray as protected __nameToArray;
    }

    use DescriptionTrait {
        DescriptionTrait::__construct as protected __descriptionConstruct;
        DescriptionTrait::__toArray as protected __descriptionToArray;
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  IntroSectionTrait constructor.
     *
     * @param string $src Image SRC of the section.
     * @param string $name Name of the section.
     * @param string $description Description of the section.
     */
    public function __construct(string $name, string $description, string $src)
    {
        $this->__nameConstruct($name);
        $this->__descriptionConstruct($description);
        $this->__srcConstruct($src);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            $this->__nameToArray(),
            $this->__descriptionToArray(),
            $this->__srcToArray(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}