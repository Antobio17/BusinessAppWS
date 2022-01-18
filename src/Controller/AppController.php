<?php

namespace App\Controller;

use App\Controller\Interfaces\AppControllerInterface;
use App\Service\Interfaces\AppServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AppController extends AbstractController implements AppControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var AppServiceInterface
     */
    protected AppServiceInterface $appService;

    /************************************************** ROUTING ***************************************************/

    /************************************************* CONSTRUCT **************************************************/

    /**
     * AppController construct.
     *
     * @param AppServiceInterface $appService Service of App.
     */
    public function __construct(AppServiceInterface $appService)
    {
        $this->setAppService($appService);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return AppServiceInterface AppServiceInterface
     */
    public function getAppService(): AppServiceInterface
    {
        return $this->appService;
    }

    /**
     * @inheritDoc
     * @return $this $this
     */
    public function setAppService(AppServiceInterface $appService): self
    {
        $this->appService = $appService;

        return $this;
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @param array $data
     * @return Response
     */
    public function createJsonResponse(array $data): Response
    {
        $errors = $this->getAppService()->getErrors();
        $response = array(
            'data' => serialize($data),
            'result' => empty($errors),
            'code' => 200,
        );

        if (!empty($errors)):
            $response['code'] = $errors[0]->getArrayData()['exceptionCode'];
            $response['message'] = $errors[0]->getArrayData()['exceptionMessage'];
        endif;

        return new JsonResponse($response);
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}