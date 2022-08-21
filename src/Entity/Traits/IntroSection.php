<?php

namespace App\Entity\Traits;

use App\Entity\Image;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use App\Entity\Traits\Interfaces\HasIntroSectionInterface;

/**
 * Trait to implement IntroSectionTrait property.
 *
 * @see HasIntroSectionInterface
 */
trait IntroSection
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * One BusinessService has One Image.
     *
     * @OneToOne(targetEntity="App\Entity\Image", cascade={"all"})
     * @JoinColumn(name="image_id", referencedColumnName="id")
     */
    protected Image $image;

    use NameTrait {
        NameTrait::__construct as protected __nameConstruct;
        NameTrait::__toArray as protected __nameToArray;
    }

    use DescriptionTrait {
        DescriptionTrait::__construct as protected __descriptionConstruct;
        DescriptionTrait::__toArray as protected __descriptionToArray;
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return Image Image
     */
    public function getImage(): Image
    {
        return $this->image;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setImage(Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  IntroSectionTrait constructor.
     *
     * @param Image $image Image of the section.
     * @param string $name Name of the section.
     * @param string $description Description of the section.
     */
    public function __construct(Image $image, string $name, string $description)
    {
        $this->__nameConstruct($name);
        $this->__descriptionConstruct($description);

        $this->setImage($image);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array_merge(
            $this->__nameToArray(),
            $this->__descriptionToArray(),
            array(
                'image' => $this->getImage()->__toArray(),
            )
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}