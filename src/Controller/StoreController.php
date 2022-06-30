<?php

namespace App\Controller;

use App\Service\Interfaces\StoreServiceInterface;
use App\Service\Traits\StoreServiceTrait;
use App\Controller\Interfaces\StoreControllerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoreController extends AppController implements StoreControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

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
     * @Route("/api/get/store/products")
     *
     * @inheritDoc
     * @return JsonResponse JsonResponse
     */
    public function getBusinessProducts(Request $request): Response
    {
        $domain = $request->server->get(static::REQUEST_SERVER_HTTP_HOST);
        $offset = $request->request->get(static::REQUEST_FIELD_OFFSET);
        $limit = $request->request->get(static::REQUEST_FIELD_LIMIT);

        # Data Validation
        $validationErrors = $this->validateRequestIntegerFields(array(
            static::REQUEST_FIELD_OFFSET => $offset,
            static::REQUEST_FIELD_LIMIT => $limit,
        ));

        $data = NULL;
        if (empty($validationErrors)):
            $offset = $offset !== NULL ? (int)$offset : NULL;
            $limit = $limit !== NULL ? (int)$limit : NULL;
            if ($this->getStoreService()->setBusinessContext($domain)):
                $data = $this->getStoreService()->getBusinessProducts($offset, $limit);
            endif;
        endif;

        return $this->createJsonResponse($data, $validationErrors, $this->getStoreService());
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}