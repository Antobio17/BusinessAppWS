<?php /** @noinspection DuplicatedCode */

namespace App\Controller;

use App\Service\Traits\StoreServiceTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Interfaces\StoreServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\Interfaces\StoreControllerInterface;

class StoreController extends AppController implements StoreControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

    public const REQUEST_FIELD_POSTAL_ADDRESS_ID = 'postalAddressID';
    public const REQUEST_FIELD_AMOUNT = 'amount';
    public const REQUEST_FIELD_UUID = 'uuid';
    public const REQUEST_FIELD_PRODUCTS_DATA = 'productsData';
    public const REQUEST_FIELD_ORDER_ID = 'orderID';
    public const REQUEST_FIELD_SORT = 'sort';
    public const REQUEST_FIELD_ON_STOCK = 'onStock';
    public const REQUEST_FIELD_OUT_OF_STOCK = 'outOfStock';
    public const REQUEST_FIELD_CATEGORY_EXCLUSION = 'categoryExclusion';

    public const PRODUCT_DATA_KEY_ID = 'productID';
    public const PRODUCT_DATA_KEY_NAME = 'name';
    public const PRODUCT_DATA_KEY_PRICE = 'price';
    public const PRODUCT_DATA_KEY_DISCOUNT_PERCENT = 'discountPercent';
    public const PRODUCT_DATA_KEY_NUMBER = 'number';

    /************************************************* PROPERTIES *************************************************/

    use StoreServiceTrait;

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  StoreController constructor.
     *
     * @param StoreServiceInterface $storeService Service of Store.
     */
    public function __construct(StoreServiceInterface $storeService)
    {
        parent::__construct();

        $this->setStoreService($storeService);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /************************************************** ROUTING ***************************************************/

    /**
     * @Route("/api/store/product/get")
     *
     * @inheritDoc
     * @return JsonResponse JsonResponse
     */
    public function getBusinessProducts(Request $request): JsonResponse
    {
        $domain = $request->server->get(static::REQUEST_SERVER_HTTP_REFERER);
        $offset = $this->getParamFromRequest($request, static::REQUEST_FIELD_OFFSET);
        $limit = $this->getParamFromRequest($request, static::REQUEST_FIELD_LIMIT);
        $sort = $this->getParamFromRequest($request, static::REQUEST_FIELD_SORT);
        $onStock = $this->getParamFromRequest($request, static::REQUEST_FIELD_ON_STOCK);
        $outOfStock = $this->getParamFromRequest($request, static::REQUEST_FIELD_OUT_OF_STOCK);
        $categoryExclusion = $this->getParamFromRequest($request, static::REQUEST_FIELD_CATEGORY_EXCLUSION);

        # Data Validation
        $validationErrors = $this->validateRequestNumericFields(array(
            static::REQUEST_FIELD_OFFSET => $offset,
            static::REQUEST_FIELD_LIMIT => $limit,
        ));

        if (empty($validationErrors) && $this->getStoreService()->setBusinessContext($domain)):
            $offset = $offset !== NULL ? (int)$offset : NULL;
            $limit = $limit !== NULL ? (int)$limit : NULL;
            $data = $this->getStoreService()->getBusinessProducts(
                $offset, $limit, $sort, $onStock, $outOfStock, $categoryExclusion
            );
        endif;

        return $this->createJsonResponse($data ?? NULL, $validationErrors, $this->getStoreService());
    }

    /**
     * @Route("/api/store/order/create")
     *
     * @inheritDoc
     * @return JsonResponse JsonResponse
     */
    public function notifyNewOrder(Request $request): JsonResponse
    {
        $domain = $request->server->get(static::REQUEST_SERVER_HTTP_REFERER);
        $postalAddressID = $this->getParamFromRequest($request, static::REQUEST_FIELD_POSTAL_ADDRESS_ID);
        $amount = $this->getParamFromRequest($request, static::REQUEST_FIELD_AMOUNT);
        $UUID = $this->getParamFromRequest($request, static::REQUEST_FIELD_UUID);
        $productsData = $this->getParamFromRequest($request, static::REQUEST_FIELD_PRODUCTS_DATA);

        # Data Validation
        $validationErrors = array_merge(
            $this->validateRequiredRequestFields(array(
                static::REQUEST_FIELD_POSTAL_ADDRESS_ID => $postalAddressID,
                static::REQUEST_FIELD_AMOUNT => $amount,
                static::REQUEST_FIELD_UUID => $UUID,
                static::REQUEST_FIELD_PRODUCTS_DATA => $productsData,
            )),
            $this->validateRequestNumericFields(array(
                static::REQUEST_FIELD_POSTAL_ADDRESS_ID => $postalAddressID,
                static::REQUEST_FIELD_AMOUNT => $amount,
            )),
            $this->_validateRequestProductsData(array(
                static::REQUEST_FIELD_PRODUCTS_DATA => $productsData,
            ))
        );

        if (empty($validationErrors)):
            $postalAddressID = (int)$postalAddressID;
            $amount = (float)$amount;
            $productsData = json_decode($productsData, TRUE);
            if ($this->getStoreService()->setBusinessContext($domain)):
                $data = $this->getStoreService()->notifyNewOrder($postalAddressID, $amount, $UUID, $productsData);
            endif;
        endif;

        return $this->createJsonResponse_Creation($data ?? NULL, $validationErrors, $this->getStoreService());
    }

    /**
     * @Route("/api/store/order/cancel")
     *
     * @inheritDoc
     * @return JsonResponse JsonResponse
     */
    public function cancelPendingOrder(Request $request): JsonResponse
    {
        $domain = $request->server->get(static::REQUEST_SERVER_HTTP_REFERER);
        $orderID = $this->getParamFromRequest($request, static::REQUEST_FIELD_ORDER_ID);

        # Data Validation
        $validationErrors = array_merge(
            $this->validateRequiredRequestFields(array(
                static::REQUEST_FIELD_ORDER_ID => $orderID,
            )),
            $this->validateRequestNumericFields(array(
                static::REQUEST_FIELD_ORDER_ID => $orderID,
            )),
        );

        if (empty($validationErrors)):
            $orderID = (int)$orderID;
            if ($this->getStoreService()->setBusinessContext($domain)):
                $data = $this->getStoreService()->cancelPendingOrder($orderID);
            endif;
        endif;

        return $this->createJsonResponse($data ?? NULL, $validationErrors, $this->getStoreService());
    }

    /**
     * @Route("/api/store/category/get")
     *
     * @inheritDoc
     * @return JsonResponse JsonResponse
     */
    public function getProductCategories(Request $request): JsonResponse
    {
        $domain = $request->server->get(static::REQUEST_SERVER_HTTP_REFERER);

        if ($this->getStoreService()->setBusinessContext($domain)):
            $data = $this->getStoreService()->getProductCategories();
        endif;

        return $this->createJsonResponse($data ?? NULL, array(), $this->getStoreService());
    }

    /**
     * @Route("/api/store/order/user/get")
     *
     * @inheritDoc
     * @return JsonResponse JsonResponse
     */
    public function getUserOrders(Request $request): JsonResponse
    {
        $domain = $request->server->get(static::REQUEST_SERVER_HTTP_REFERER);
        $offset = $this->getParamFromRequest($request, static::REQUEST_FIELD_OFFSET);
        $limit = $this->getParamFromRequest($request, static::REQUEST_FIELD_LIMIT);
        $status = $this->getParamFromRequest($request, static::REQUEST_FIELD_STATUS);

        # Data Validation
        $validationErrors = $this->validateRequestNumericFields(array(
            static::REQUEST_FIELD_OFFSET => $offset,
            static::REQUEST_FIELD_LIMIT => $limit,
        ));

        if (empty($validationErrors) && $this->getStoreService()->setBusinessContext($domain)):
            $offset = $offset !== NULL ? (int)$offset : NULL;
            $limit = $limit !== NULL ? (int)$limit : NULL;
            $status = is_array($status) ? $status : array();
            $data = $this->getStoreService()->getUserOrders($status, $offset, $limit);
        endif;

        return $this->createJsonResponse($data ?? NULL, $validationErrors, $this->getStoreService());
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /********************************************** PROTECTED METHODS *********************************************/

    /**
     * Validates the data of the product passed in the request.
     *
     *      return array(
     *          array(
     *              'field' => $key,
     *              'message' => sprintf('The %s field must be integer', $key)
     *          )
     *      )
     *
     * @param array $requestFields Request field of the data product.
     *
     * @return array array
     */
    protected function _validateRequestProductsData(array $requestFields): array
    {
        $validationErrors = array();

        $fieldName = array_keys($requestFields)[0];
        $productsData = json_decode(array_values($requestFields)[0], TRUE);

        if (!empty($productsData) && is_array($productsData)):
            foreach ($productsData as $product):
                if (
                    !isset($product[static::PRODUCT_DATA_KEY_ID]) || !is_numeric($product[static::PRODUCT_DATA_KEY_ID])
                ):
                    $validationErrors[] = array(
                        'field' => static::PRODUCT_DATA_KEY_ID,
                        'message' => sprintf(
                            'The data %s of the product is required and it must be an integer',
                            static::PRODUCT_DATA_KEY_ID
                        )
                    );
                elseif (!isset($product[static::PRODUCT_DATA_KEY_NAME])):
                    $validationErrors[] = array(
                        'field' => static::PRODUCT_DATA_KEY_NAME,
                        'message' => sprintf(
                            'The data %s of the product is required',
                            static::PRODUCT_DATA_KEY_NAME
                        )
                    );
                elseif (
                    !isset($product[static::PRODUCT_DATA_KEY_PRICE])
                    || !is_numeric($product[static::PRODUCT_DATA_KEY_PRICE])
                ):
                    $validationErrors[] = array(
                        'field' => static::PRODUCT_DATA_KEY_PRICE,
                        'message' => sprintf(
                            'The data %s of the product is required and it must be numeric',
                            static::PRODUCT_DATA_KEY_PRICE
                        )
                    );
                elseif (
                    !isset($product[static::PRODUCT_DATA_KEY_DISCOUNT_PERCENT])
                    || !is_numeric($product[static::PRODUCT_DATA_KEY_DISCOUNT_PERCENT])
                ):
                    $validationErrors[] = array(
                        'field' => static::PRODUCT_DATA_KEY_DISCOUNT_PERCENT,
                        'message' => sprintf(
                            'The data %s of the product is required and it must be an integer',
                            static::PRODUCT_DATA_KEY_DISCOUNT_PERCENT
                        )
                    );
                elseif (
                    !isset($product[static::PRODUCT_DATA_KEY_ID])
                    || !is_numeric($product[static::PRODUCT_DATA_KEY_ID])
                ):
                    $validationErrors[] = array(
                        'field' => static::PRODUCT_DATA_KEY_ID,
                        'message' => sprintf(
                            'The data %s of the product is required and it must be an integer',
                            static::PRODUCT_DATA_KEY_ID
                        )
                    );
                endif;
            endforeach;
        else:
            $validationErrors[] = array(
                'field' => $fieldName,
                'message' => sprintf('The %s field must be an array', $fieldName)
            );
        endif;

        return $validationErrors;
    }

    /*********************************************** STATIC METHODS ***********************************************/

}