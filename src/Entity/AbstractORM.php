<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Interfaces\AbstractORMInterface;

/**
 * AbstractORM entity.
 */
abstract class AbstractORM implements AbstractORMInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var int|null
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /************************************************* CONSTRUCT **************************************************/

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return int int
     */
    public function getID(): int
    {
        return $this->id;
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(
            'id' => $this->getID(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}