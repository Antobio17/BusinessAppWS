<?php

namespace App\Service;

use App\Controller\StoreController;
use App\Entity\User;
use App\Entity\Order;
use App\Entity\AppError;
use App\Helper\ToolsHelper;
use App\Service\Interfaces\StoreServiceInterface;
use App\Service\Interfaces\StripeServiceInterface;
use App\Service\Traits\StripeServiceTrait;
use Doctrine\Persistence\ManagerRegistry;
use Stripe\Exception\ApiErrorException;
use Symfony\Component\Lock\LockFactory;

class StoreService extends AppService implements StoreServiceInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    use StripeServiceTrait;

    /************************************************* CONSTRUCT **************************************************/

    /**
     * AppService construct.
     *
     * @param ManagerRegistry $doctrine Doctrine to manage the ORM.
     * @param TelegramService $telegramService Service of Telegram.
     * @param LockFactory $lockFactory The lock factory instance.
     * @param StripeServiceInterface $stripeService The stripe service of the app.
     * @param bool $testMode Boolean to set the Test Mode.
     */
    public function __construct(ManagerRegistry $doctrine, TelegramService $telegramService,
                                LockFactory     $lockFactory, StripeServiceInterface $stripeService,
                                bool            $testMode = FALSE)
    {
        parent::__construct($doctrine, $telegramService, $lockFactory, $testMode);

        $this->setStripeService($stripeService);
    }

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
    public function notifyNewOrder(int $postalAddressID, float $amount, array $productsData): ?Order
    {
        $method = ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__);

        $user = $this->getUser();
        $business = $this->getBusiness();
        if ($business === NULL):
            $this->registerAppError_BusinessContextUndefined($method);
        elseif (!$user instanceof User || $user->getEmail() === NULL):
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
                $ttl = 30;
                $locks = array();
                $businessName = ToolsHelper::getStrLikeSnakeCase($business->getName());
                foreach ($productsData as $productData):
                    $lockName = $this->_getLockName_createEntityFromValue(
                        Order::class, sprintf(
                            '%s_%s', $productData[StoreController::PRODUCT_DATA_KEY_ID], $businessName
                        )
                    );
                    $locks[] = $this->createLock($lockName, $ttl);
                endforeach;

                $this->_checkProductAvailability($productsData, $method);
                try {
                    if ($business->getClientSecret() !== NULL):
                        $this->getStripeService()->initClient($business->getClientSecret());
                    endif;
                    $paymentIntent = $this->getStripeService()->createPaymentIntent(
                        $amount, $user->getEmail(),
                        sprintf('Intento de pago para el usuario %s.', $user->getEmail() ?? 'Nulo')
                    );
                    if ($paymentIntent->client_secret !== NULL):
                        $order = new Order(
                            $business, $user, $postalAddress, $amount,
                            $paymentIntent->id, $paymentIntent->client_secret, $productsData
                        );
                        $this->persistAndFlush($order);
                    else:
                        $this->registerAppError(
                            $method, AppError::ERROR_STORE_STRIPE_CLIENT_SECRET_NULL,
                            'Error en el intento de pedido con Stripe: client_secret es nulo.'
                        );
                    endif;
                } catch (ApiErrorException $e) {
                    $this->registerAppError(
                        $method, AppError::ERROR_STORE_STRIPE_PAYMENT_INTENT_ERROR,
                        'Error en el intento de pedido con Stripe.',
                        $e->getCode(), $e->getMessage(), $e->getTrace()
                    );
                }

                foreach ($locks as $lock):
                    $this->releaseLock($method, $lock, $ttl);
                endforeach;
            endif;
        endif;

        return $order ?? NULL;
    }

    /**
     * @inheritDoc
     * @return bool bool
     */
    public function notifyPaymentOrder(string $paymentIntentID, bool $success): ?bool
    {
        $method = ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__);

        $user = $this->getUser();
        if (!$user instanceof User):
            $this->registerAppError_UserContextUndefined($method);
        else:
            $order = $this->getOrderRepository()->findByUUID($paymentIntentID);
            /** @noinspection PhpPossiblePolymorphicInvocationInspection */
            if ($order !== NULL && $order->getUser()->getID() === $user->getID()):
                if ($success && $order->getStatus() === Order::STATUS_PENDING):
                    $order->setStatus(Order::STATUS_PAID);
                    $this->persistAndFlush($order);
                elseif (!$success && $order->getStatus() === Order::STATUS_PENDING):
                    $this->removeOrder($order);
                endif;
            else:
                $this->registerAppError(
                    $method, AppError::ERROR_STORE_INCORRECT_ORDER,
                    'Error en la notificación de pago del pedido: el pedido no corresponde al usuario.'
                );
            endif;
        endif;

        return empty($this->getErrors());
    }

    /**
     * @inheritDoc
     */
    public function removeOrder(Order $order)
    {
        $method = ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__);

        $productsData = $order->getData();
        foreach ($productsData as $productData):
            $productID = (int)$productData[StoreController::PRODUCT_DATA_KEY_ID];
            $quantity = (int)$productData[StoreController::PRODUCT_DATA_KEY_QUANTITY];
            $product = $this->getProductRepository()->find($productID);
            if ($product !== NULL):
                $ttl = 30;
                $businessName = ToolsHelper::getStrLikeSnakeCase($order->getBusiness()->getName());
                $lockName = $this->_getLockName_createEntityFromValue(
                    Order::class, sprintf('%s_%s', $productID, $businessName)
                );
                $lock = $this->createLock($lockName, $ttl);
                $product->setStock($product->getStock() + $quantity);
                $this->persistAndFlush($product);
                $this->releaseLock($method, $lock, $ttl);
            endif;
        endforeach;

        $this->getEntityManager()->remove($order);
        $this->getEntityManager()->flush();
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
            if ($order === NULL || $order->getStatus() !== Order::STATUS_PAID):
                $message = $order !== NULL ? 'su estado no es PAGADO' : 'no existe';
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