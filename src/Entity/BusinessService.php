<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\NameTrait;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use App\Entity\Traits\DescriptionTrait;
use Doctrine\ORM\Mapping\AttributeOverride;
use Doctrine\ORM\Mapping\AttributeOverrides;
use App\Repository\BusinessServiceRepository;
use App\Entity\Interfaces\HomeConfigInterface;
use App\Entity\Interfaces\BusinessServiceInterface;

/**
 * BusinessService entity.
 *
 * @ORM\Entity(repositoryClass=BusinessServiceRepository::class)
 * @AttributeOverrides({
 *     @AttributeOverride(name="name",
 *          column=@Column(
 *              name   = "title",
 *              unique = false,
 *              length = 1024
 *          )
 *      )
 * })
 */
class BusinessService extends AbstractORM implements BusinessServiceInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    /**
     * @ManyToOne(targetEntity="App\Entity\HomeConfig", inversedBy="businessServices")
     * @JoinColumn(name="home_config_id", referencedColumnName="id", nullable=false)
     */
    protected HomeConfigInterface $homeConfig;

    /**
     * One BusinessService has One Image.
     *
     * @OneToOne(targetEntity="App\Entity\Image", cascade={"all"})
     * @JoinColumn(name="image_id", referencedColumnName="id")
     */
    protected Image $image;

    use NameTrait {
        NameTrait::__construct as protected __titleConstruct;
        NameTrait::__toArray as protected __titleToArray;
    }

    use DescriptionTrait {
        DescriptionTrait::__construct as protected __descriptionConstruct;
        DescriptionTrait::__toArray as protected __descriptionToArray;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  Image constructor.
     *
     * @param HomeConfigInterface $homeConfig HomeConfig to belong.
     */
    public function __construct(HomeConfigInterface $homeConfig, Image $image, string $title, string $description)
    {
        $this->__titleConstruct($title);
        $this->__descriptionConstruct($description);

        $this->setHomeConfig($homeConfig);
        $this->setImage($image);
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

    /**
     * @inheritDoc
     * @return string string
     */
    public function getTitle(): string
    {
        return $this->getName();
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setTitle(string $title): self
    {
        return $this->setName($title);
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
                'image' => $this->getImage()->__toArray(),
                'title' => $this->getTitle(),
            ),
            $this->__descriptionToArray(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/
}