<?php

namespace App\Entity;

use App\Entity\Traits\AltTrait;
use App\Entity\Traits\HeightTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\WidthTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use App\Entity\Interfaces\ImageInterface;
use App\Entity\Interfaces\HomeConfigInterface;

/**
 * Image entity.
 *
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image extends AbstractORM implements ImageInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ManyToOne(targetEntity="App\Entity\HomeConfig", inversedBy="socialImages")
     * @JoinColumn(name="home_config_id", referencedColumnName="id", nullable=false)
     */
    protected HomeConfigInterface $homeConfig;

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
     * @param HomeConfigInterface $homeConfig HomeConfig to belong.
     * @param int $width Width of the image.
     * @param int $height Height od the image.
     */
    public function __construct(HomeConfigInterface $homeConfig, string $name, int $width, int $height, string $alt)
    {
        $this->__nameConstruct($name);
        $this->__widthConstruct($width);
        $this->__heightConstruct($height);
        $this->__altConstruct($alt);

        $this->setHomeConfig($homeConfig);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return HomeConfigInterface HomeConfigInterface
     */
    public function getHomeConfig(): HomeConfigInterface
    {
        return $this->homeConfig;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setHomeConfig(HomeConfigInterface $homeConfig): self
    {
        $this->homeConfig = $homeConfig;

        return $this;
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array_merge(
            parent::__toArray(),
            array(
                'homeConfigID' => $this->getHomeConfig()->getID(),
                $this->__nameToArray(),
                $this->__widthToArray(),
                $this->__heightToArray(),
                $this->__altToArray(),
            ),
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