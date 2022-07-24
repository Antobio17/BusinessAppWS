<?php

namespace App\Entity\Traits;

use App\Entity\Traits\Interfaces\HasSocialSectionInterface;

/**
 * Trait to implement SocialSectionTrait property.
 *
 * @see HasSocialSectionInterface
 */
trait SocialSectionTrait
{

    /************************************************* PROPERTIES *************************************************/

    use DataTrait {
        DataTrait::__construct as protected __dataConstruct;
        DataTrait::__toArray as protected __dataToArray;
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function getSocialData(): array
    {
        return $this->getData();
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setSocialData(array $socialData): self
    {
        return $this->setData($socialData);
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  SocialSectionTrait constructor.
     *
     * @param array $socialData Data related to the social section.
     */
    public function __construct(array $socialData)
    {
        $this->__dataConstruct($socialData);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            $this->__dataToArray(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}