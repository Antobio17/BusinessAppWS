<?php

namespace App\Service;

use App\Helper\ToolsHelper;
use App\Service\Interfaces\StoreServiceInterface;

class StoreService extends AppService implements StoreServiceInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    /************************************************* CONSTRUCT **************************************************/

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function getBusinessProducts(?int $offset, ?int $limit): ?array
    {
        if ($this->getBusiness() !== NULL):
            $products = $this->getProductRepository()->findByOffset($this->getBusiness(), $offset, $limit);
            $totalProducts = $this->getProductRepository()->getCount($this->getBusiness());
            $result = array(
                'products' => $products,
                'total' => $totalProducts,
            );
        else:
            $result = NULL;
            $this->registerAppError_BusinessContextUndefined(
                ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__)
            );
        endif;

        return $result;
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}