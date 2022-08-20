<?php

namespace App\Entity\Traits;

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
     * @return array array
     */
    public function getSocialImages(): array
    {
        return $this->getData();
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function addSocialImage(array $socialData): self
    {
        return $this->setData($socialData);
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