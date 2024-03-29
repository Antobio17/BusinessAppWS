<?php

namespace App\Entity\Interfaces;

use App\Entity\Traits\Interfaces\HasImageInterface;

/**
 * Image interface.
 */
interface ImageInterface extends HasImageInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the entity.
     *
     *      Returns array(
     *          'name' => $this->>getName(),
     *          'width' => $this->>getWidth(),
     *          'height' => $this->>getHeight(),
     *          'alt' => $this->>getAlt()
     *      )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}