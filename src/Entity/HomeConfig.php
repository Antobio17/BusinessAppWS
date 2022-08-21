<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\IntroSection;
use App\Repository\HomeConfigRepository;
use App\Entity\Traits\SocialSectionTrait;
use App\Entity\Traits\ServicesSectionTrait;
use App\Entity\Interfaces\BusinessInterface;
use App\Entity\Interfaces\HomeConfigInterface;

/**
 * HomeConfig entity.
 *
 * @ORM\Entity(repositoryClass=HomeConfigRepository::class)
 */
class HomeConfig extends AbstractBusinessContext implements HomeConfigInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    use IntroSection {
        IntroSection::__construct as protected __introSectionConstruct;
        IntroSection::__toArray as protected __introSectionToArray;
    }

    use SocialSectionTrait {
        SocialSectionTrait::__construct as protected __socialSectionConstruct;
        SocialSectionTrait::__toArray as protected __socialSectionToArray;
    }

    use ServicesSectionTrait {
        ServicesSectionTrait::__construct as protected __servicesSectionConstruct;
        ServicesSectionTrait::__toArray as protected __servicesSectionToArray;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  Order constructor.
     *
     * @param BusinessInterface $business Business to which the HomeConfig belongs.
     * @param Image $image Image of the HomeConfig.
     * @param string $name Name of the HomeConfig.
     * @param string $description Description of the HomeConfig.
     */
    public function __construct(BusinessInterface $business, Image $image, string $name, string $description)
    {
        parent::__construct($business);

        $this->__introSectionConstruct($image, $name, $description);
        $this->__socialSectionConstruct();
        $this->__servicesSectionConstruct(array());
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
            parent::__toArray(),
        );
    }

    /**
     * @inheritDoc
     * @return string string
     */
    public function __toString(): string
    {
        return $this->getBusiness()->getName();
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}