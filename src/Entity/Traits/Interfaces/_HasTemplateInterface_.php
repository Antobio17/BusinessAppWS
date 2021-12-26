<?php

namespace App\Entity\Traits\Interfaces;

/**
 * _TemplateTrait_ interface
 */
interface _HasTemplateInterface_
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * ToArray function of the property.
     * Returns array(
     *      '_Template_' => $_template_,
     * )
     *
     * @return array array
     */
    public function __toArray(): array;

    /*********************************************** STATIC METHODS ***********************************************/

}