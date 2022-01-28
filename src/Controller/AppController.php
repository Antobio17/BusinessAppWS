<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Service\Interfaces\AppServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\Interfaces\AppControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController implements AppControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    /************************************************** ROUTING ***************************************************/

    /************************************************* CONSTRUCT **************************************************/

    /**
     * AppController construct.
     */
    public function __construct()
    {

    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @param array $data
     * @param array $validationErrors
     * @param AppServiceInterface $service
     * @param int $code
     *
     * @return Response Response
     * @noinspection PhpMissingParamTypeInspection
     */
    public function createJsonResponse($data, array $validationErrors, AppServiceInterface $service,
                                       int $code = 200): Response
    {
        if (empty($validationErrors)):
            $serviceErrors = $service->getErrors();
            $response = array(
                'data' => $data,
                'result' => empty($serviceErrors),
                'code' => $code,
            );

            if (!empty($serviceErrors)):
                $response['code'] = $serviceErrors[0]->getExceptionCode() ?? $serviceErrors[0]->getType();
                $response['message'] = $serviceErrors[0]->getExceptionMessage() ?? $serviceErrors[0]->getMessage();
            endif;
        else:
            $response['code'] = Response::HTTP_BAD_REQUEST;
            $response['message'] = 'Validation failed';
            $response['errors'] = $validationErrors;
        endif;

        return new JsonResponse($response);
    }

    /**
     * @param $data
     * @param array $validationErrors
     * @param AppServiceInterface $service
     *
     * @return Response Response
     * @noinspection PhpMissingParamTypeInspection
     */
    public function createJsonResponse_Creation($data, array $validationErrors, AppServiceInterface $service): Response
    {
        return $this->createJsonResponse($data, $validationErrors, $service, Response::HTTP_CREATED);
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}