<?php

namespace App\Controller;

use App\Service\Traits\BusinessServiceTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Interfaces\BusinessServiceInterface;
use App\Controller\Interfaces\BusinessControllerInterface;

class BusinessController extends AppController implements BusinessControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    use BusinessServiceTrait;

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  BusinessController constructor.
     *
     * @param BusinessServiceInterface $businessService Service of Business.
     *
     */
    public function __construct(BusinessServiceInterface $businessService)
    {
        parent::__construct();

        $this->setBusinessService($businessService);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /************************************************** ROUTING ***************************************************/

    /**
     * @Route("/api/business/config/home/get")
     *
     * @inheritDoc
     * @return JsonResponse JsonResponse
     */
    public function getBusinessHomeConfig(Request $request): JsonResponse
    {
        $domain = $request->server->get(static::REQUEST_SERVER_HTTP_REFERER);

        if ($this->getBusinessService()->setBusinessContext($domain)):
            $data = $this->getBusinessService()->getBusinessHomeConfig();
        endif;

        return $this->createJsonResponse($data ?? NULL, array(), $this->getBusinessService());
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}