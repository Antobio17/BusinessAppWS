<?php

namespace App\Entity\Traits;

use App\Entity\Image;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\Collection;
use App\Entity\Traits\Interfaces\HasSocialSectionInterface;

/**
 * Trait to implement SocialSectionTrait property.
 *
 * @see HasSocialSectionInterface
 */
trait SocialSectionTrait
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * One Business has many shifts.
     *
     * @OneToMany(targetEntity="Image", mappedBy="homeConfig", cascade={"all"})
     */
    protected Collection $socialImages;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return Image[]|Collection Image[]|Collection
     */
    public function getSocialImages(): Collection
    {
        return $this->socialImages;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function addSocialImage(Image $socialData): self
    {
        $this->socialImages->add($socialData);

        return $this;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  SocialSectionTrait constructor.
     *
     */
    public function __construct()
    {
        $this->socialImages = new ArrayCollection();
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function getSocialImagesAsArray(): array
    {
        foreach ($this->getSocialImages() as $image):
            $socialImages[] = $image->__toArray();
        endforeach;

        return $socialImages ?? array();
    }

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            $this->getSocialImagesAsArray(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}