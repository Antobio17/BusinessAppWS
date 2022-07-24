<?php

namespace App\Controller;

use App\Service\Traits\BusinessServiceTrait;
use App\Service\Interfaces\BusinessServiceInterface;
use App\Controller\Interfaces\BusinessControllerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @return Response Response
     */
    public function getBusinessHomeConfig(Request $request): Response
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