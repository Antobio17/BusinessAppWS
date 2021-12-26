<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Interfaces\_HasTemplateInterface_;

/**
 * Trait to implement _Template_ property.
 *
 * @see _HasTemplateInterface_
 */
trait _TemplateTrait_
{

    /************************************************* PROPERTIES *************************************************/

    /******************************************** GETTERS AND SETTERS *********************************************/

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  _TemplateTrait_ constructor.
     */
    public function __construct()
    {

    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array(

        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}