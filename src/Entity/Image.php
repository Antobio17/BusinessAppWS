<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\ImageTrait;
use Doctrine\ORM\Mapping\ManyToOne;
use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping\JoinColumn;
use App\Entity\Interfaces\ImageInterface;

/**
 * Image entity.
 *
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image extends AbstractORM implements ImageInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    use ImageTrait {
        ImageTrait::__construct as protected __imageConstruct;
        ImageTrait::__toArray as protected __imageToArray;
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
        $this->__imageConstruct($name, $width, $height, $alt);
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
            $this->__imageToArray(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/
}