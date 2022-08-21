<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\ImageTrait;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use App\Repository\SocialImageRepository;
use App\Entity\Interfaces\HomeConfigInterface;
use App\Entity\Interfaces\SocialImageInterface;

/**
 * SocialImage entity.
 *
 * @ORM\Entity(repositoryClass=SocialImageRepository::class)
 */
class SocialImage extends AbstractORM implements SocialImageInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ManyToOne(targetEntity="App\Entity\HomeConfig", inversedBy="socialImages")
     * @JoinColumn(name="home_config_id", referencedColumnName="id", nullable=false)
     */
    protected HomeConfigInterface $homeConfig;

    use ImageTrait {
        ImageTrait::__construct as protected __imageConstruct;
        ImageTrait::__toArray as protected __imageToArray;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  Image constructor.
     *
     * @param HomeConfigInterface $homeConfig HomeConfig to belong.
     * @param string $name Name of the image.
     * @param int $width Width of the image.
     * @param int $height Height od the image.
     * @param string $alt Alt of the image.
     */
    public function __construct(HomeConfigInterface $homeConfig, string $name, int $width, int $height, string $alt)
    {
        $this->__imageConstruct($name, $width, $height, $alt);

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
            $this->__imageToArray(),
            array(
                'homeConfigID' => $this->getHomeConfig()->getID(),
            ),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/
}