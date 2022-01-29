<?php

namespace App\Entity;

use App\Entity\Traits\BusinessTrait;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use App\Entity\Interfaces\BusinessInterface;
use App\Entity\Interfaces\BusinessContextInterface;

/**
 * AbstractORM entity.
 */
abstract class AbstractBusinessContext extends AbstractORM implements BusinessContextInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    use BusinessTrait {
        BusinessTrait::__construct as protected __businessConstruct();
        BusinessTrait::__toArray as protected __businessToArray();
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     * BusinessContext construct.
     *
     * @param BusinessInterface $business The business to set in the entity.
     *
     */
    public function __construct(BusinessInterface $business)
    {
        $this->__businessConstruct($business);
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
            $this->__businessToArray()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}