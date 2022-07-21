<?php

namespace App\Entity\Interfaces;

use App\Entity\Traits\Interfaces\HasIntroSectionInterface;
use App\Entity\Traits\Interfaces\HasServicesSectionInterface;
use App\Entity\Traits\Interfaces\HasSocialSectionInterface;

/**
 * HomeConfig interface.
 */
interface HomeConfigInterface extends HasIntroSectionInterface, HasSocialSectionInterface, HasServicesSectionInterface
{

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}