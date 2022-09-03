<?php

namespace App\Service;

use App\Controller\StoreController;
use App\Entity\User;
use App\Entity\Order;
use App\Entity\AppError;
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
    public function getBusinessProducts(?int  $offset = NULL, ?int $limit = NULL, ?string $sort = NULL,
                                        bool  $onStock = TRUE, bool $outOfStock = TRUE,
                                        array $categoryExclusion = array()): ?array
    {
        if ($this->getBusiness() === NULL):
            $this->registerAppError_BusinessContextUndefined(
                ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__)
            );
        else:
            $products = $this->getProductRepository()->findByFilters(
                $this->getBusiness(), $offset, $limit, $sort, $onStock, $outOfStock, $categoryExclusion
            );
            foreach ($products as $product):
                $productsArray[] = $product->__toArray();
            endforeach;
            $totalProducts = $this->getProductRepository()->getCount(
                $this->getBusiness(), $onStock, $outOfStock, $categoryExclusion
            );
            $result = array(
                'products' => $productsArray ?? array(),
                'total' => $totalProducts,
            );
        endif;

        return $result ?? NULL;
    }

    /**
     * @inheritDoc
     * @return bool bool
     */
    public function notifyNewOrder(int $postalAddressID, float $amount, array $productsData): ?bool
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
                $message = 'la dirección no pertenece al usuario';
                $this->registerAppError(
                    $method, AppError::ERROR_STORE_INCORRECT_POSTAL_ADDRESS,
                    sprintf('Error en la creación de pedido: %s.', $message)
                );
            endif;

            if (empty($this->getErrors())):
                # TODO semaphore
                $this->_checkProductAvailability($productsData, $method);
                $order = new Order($this->getBusiness(), $user, $postalAddress, $amount, NULL, $productsData);
                # TODO end semaphore
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
                    sprintf('Error en la cancelación del pedido: %s.', $message)
                );
            /** @noinspection PhpPossiblePolymorphicInvocationInspection */
            elseif ($order->getUser()->getID() !== $user->getID()):
                $this->registerAppError(
                    $method, AppError::ERROR_STORE_INCORRECT_ORDER,
                    'Error en la cancelación del pedido: el pedido no corresponde al usuario.'
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
            foreach ($categories as $category):
                $categoriesArray[] = $category->__toArray();
            endforeach;
            $result = array('categories' => $categoriesArray ?? array());
        endif;

        return $result ?? NULL;
    }

    /**
     * @inheritDoc
     * @return array array
     */
    public function getUserOrders(array $status = array(), ?int $offset = NULL, ?int $limit = NULL): ?array
    {
        $method = ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__);

        $user = $this->getUser();
        if ($this->getBusiness() === NULL):
            $this->registerAppError_BusinessContextUndefined($method);
        elseif (!$user instanceof User):
            $this->registerAppError_UserContextUndefined($method);
        else:
            $orders = $this->getOrderRepository()->findByUser($this->getBusiness(), $user, $status, $offset, $limit);
            $totalOrders = $this->getOrderRepository()->getCountTotalOrders($this->getBusiness(), $user);
            $result = array(
                'orders' => $orders,
                'last' => $limit !== NULL && $offset + count($orders) === $totalOrders,
            );
        endif;

        return $result ?? NULL;
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /**
     * Checks the product availability in the business to create the order.
     *
     * @param array $productsData The products to check.
     * @param string $method Method that call the function.
     *
     * @return bool bool
     */
    protected function _checkProductAvailability(array $productsData, string $method): bool
    {
        $available = TRUE;

        foreach ($productsData as $productData):
            $product = $this->getProductRepository()->find((int)$productData[StoreController::PRODUCT_DATA_KEY_ID]);
            if ($product === NULL):
                $this->registerAppError(
                    $method, AppError::ERROR_STORE_PRODUCT_NOT_EXIST,
                    sprintf('Error: El producto %s no existe', $product[StoreController::PRODUCT_DATA_KEY_NAME])
                );
                $available = FALSE;
            elseif ($product->getStock() < $productData[StoreController::PRODUCT_DATA_KEY_QUANTITY]):
                if ($product->getStock() === 0):
                    $message = sprintf('Error: No hay stock del producto %s', $product->getName());
                else:
                    $message = sprintf(
                        'Error: Solo quedan %d existencias del producto %s',
                        $product->getName(), $product->getStock()
                    );
                endif;

                $this->registerAppError($method, AppError::ERROR_STORE_PRODUCT_NOT_EXIST, $message);
                $available = FALSE;
            else:
                $product->setStock(
                    $product->getStock() - (int)$productData[StoreController::PRODUCT_DATA_KEY_QUANTITY]
                );
                $this->getEntityManager()->persist($product);
            endif;
        endforeach;

        if ($available):
            $this->getEntityManager()->flush();
        else:
            $this->getEntityManager()->clear();
        endif;

        return $available;
    }

    /*********************************************** STATIC METHODS ***********************************************/

}