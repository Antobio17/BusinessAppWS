<?php

namespace App\Service;

use App\Entity\AppError;
use App\Entity\Order;
use App\Entity\User;
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
    public function getBusinessProducts(?int $offset = NULL, ?int $limit = NULL): ?array
    {
        if ($this->getBusiness() === NULL):
            $this->registerAppError_BusinessContextUndefined(
                ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__)
            );
        else:
            $products = $this->getProductRepository()->findByOffset($this->getBusiness(), $offset, $limit);
            $totalProducts = $this->getProductRepository()->getCount($this->getBusiness());
            $result = array(
                'products' => $products,
                'last' => $limit !== NULL && $offset + count($products) === $totalProducts,
            );
        endif;

        return $result ?? NULL;
    }

    /**
     * @inheritDoc
     * @return bool bool
     */
    public function notifyNewOrder(int $postalAddressID, float $amount, string $UUID, array $productsData): ?bool
    {
        $method = ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__);

        $user = $this->getUser();
        if ($this->getBusiness() === NULL):
            $this->registerAppError_BusinessContextUndefined($method);
        elseif (!$user instanceof User):
            $this->registerAppError_UserContextUndefined($method);
        else:
            $postalAddress = $user->isOwnerPostalAddress($postalAddressID);
            if ($postalAddress === NULL):
                $message = 'la direcci??n no pertenece al usuario';
                $this->registerAppError(
                    $method, AppError::ERROR_STORE_INCORRECT_POSTAL_ADDRESS,
                    sprintf('Error en la creaci??n de pedido: %s.', $message)
                );
            endif;

            if ($this->getOrderRepository()->findByUUID($UUID) !== NULL):
                $this->registerAppError(
                    $method, AppError::ERROR_STORE_UUID_EXIST,
                    'Error en la creaci??n de pedido: UUID ya registrado.'
                );
            endif;

            if (empty($this->getErrors())):
                $order = new Order($this->getBusiness(), $user, $postalAddress, $UUID, $amount, $productsData);
                $created = $this->persistAndFlush($order);
            endif;
        endif;

        return $created ?? NULL;
    }

    /**
     * @inheritDoc
     * @return bool bool
     */
    public function cancelPendingOrder(int $orderID): ?bool
    {
        $method = ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__);

        $user = $this->getUser();
        if ($this->getBusiness() === NULL):
            $this->registerAppError_BusinessContextUndefined($method);
        elseif (!$user instanceof User):
            $this->registerAppError_UserContextUndefined($method);
        else:
            $order = $this->getOrderRepository()->find($orderID);
            if ($order === NULL || $order->getStatus() !== Order::STATUS_PENDING):
                $message = $order !== NULL ? 'su estado no es PENDIENTE' : 'no existe';
                $this->registerAppError(
                    $method, AppError::ERROR_STORE_INCORRECT_ORDER,
                    sprintf('Error en la cancelaci??n del pedido: %s.', $message)
                );
            /** @noinspection PhpPossiblePolymorphicInvocationInspection */
            elseif ($order->getUser()->getID() !== $user->getID()):
                $this->registerAppError(
                    $method, AppError::ERROR_STORE_INCORRECT_ORDER,
                    'Error en la cancelaci??n del pedido: el pedido no corresponde al usuario.'
                );
            else:
                $order->setStatus(Order::STATUS_CANCELLED);
                $cancelled = $this->persistAndFlush($order);
            endif;
        endif;

        return $cancelled ?? NULL;
    }

    /**
     * @inheritDoc
     * @return array array
     */
    public function getProductCategories(): ?array
    {
        if ($this->getBusiness() === NULL):
            $this->registerAppError_BusinessContextUndefined(
                ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__)
            );
        else:
            $categoryIDs = $this->getProductRepository()->findProductCategoryIDs($this->getBusiness());
            foreach ($categoryIDs as $key => $categoryID):
                $categoryIDs[] = $categoryID['id'];
                unset($categoryIDs[$key]);
            endforeach;
            $categoryIDs = array_values($categoryIDs);
            $categories = $this->getCategoryRepository()->findByIDs($categoryIDs);
            $result = array('categories' => $categories);
        endif;

        return $result ?? NULL;
    }

    /**
     * @inheritDoc
     * @return array array
     */
    public function getUserOrders(?int $offset = NULL, ?int $limit = NULL): ?array
    {
        $method = ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__);

        $user = $this->getUser();
        if ($this->getBusiness() === NULL):
            $this->registerAppError_BusinessContextUndefined($method);
        elseif (!$user instanceof User):
            $this->registerAppError_UserContextUndefined($method);
        else:
            $orders = $this->getOrderRepository()->findByUser($this->getBusiness(), $user, $offset, $limit);
            $totalOrders = $this->getOrderRepository()->getCountTotalOrders($this->getBusiness(), $user);
            $result = array(
                'orders' => $orders,
                'last' => $limit !== NULL && $offset + count($orders) === $totalOrders,
            );
        endif;

        return $result ?? NULL;
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}