<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Interfaces\ORMInterface;

/**
 * AbstractORM entity.
 */
abstract class AbstractORM implements ORMInterface
{

    /************************************************* CONSTANTS **************************************************/

    public const SECRET_ENCRYPTION_TOKEN = 'SECRET_ENCRYPTION_TOKEN';

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var int|null
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected ?int $id = NULL;

    /************************************************* CONSTRUCT **************************************************/

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return int int
     */
    public function getID(): ?int
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