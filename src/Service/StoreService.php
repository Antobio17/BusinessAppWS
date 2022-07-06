<?php

namespace App\Service;

use App\Entity\AppError;
use App\Entity\Order;
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
                'last' => $limit !== NULL && $offset + count($products) === $totalProducts,
            );
        else:
            $result = NULL;
            $this->registerAppError_BusinessContextUndefined(
                ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__)
            );
        endif;

        return $result;
    }

    /**
     * @inheritDoc
     * @return array array
     */
    public function notifyNewOrder(int $postalAddressID, float $amount, string $UUID, array $productsData): ?bool
    {
        $result = NULL;

        if ($this->getBusiness() !== NULL):
            $user = $this->getUser();
            /** @noinspection PhpPossiblePolymorphicInvocationInspection */
            $postalAddress = $user->isOwnerPostalAddress($postalAddressID);
            if ($postalAddress === NULL):
                $message = 'la dirección no pertenece al usuario';
                $this->registerAppError(
                    ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__),
                    AppError::ERROR_STORE_INCORRECT_POSTAL_ADDRESS,
                    sprintf('Error en la creación de pedido: %s.', $message)
                );
            endif;

            if ($this->getOrderRepository()->findByUUID($UUID) !== NULL):
                $this->registerAppError(
                    ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__),
                    AppError::ERROR_STORE_UUID_EXIST,
                    'Error en la creación de pedido: UUID ya registrado.'
                );
            endif;

            if (empty($this->getErrors())):
                $order = new Order($this->getBusiness(), $user, $postalAddress, $UUID, $amount);
                $created = $this->persistAndFlush($order);
            endif;
        else:
            $this->registerAppError_BusinessContextUndefined(
                ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__)
            );
        endif;

        return $created ?? NULL;
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}