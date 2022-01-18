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
     * @param AppServiceInterface $service
     *
     * @return Response Response
     */
    public function createJsonResponse(array $data, AppServiceInterface $service): Response
    {
        $errors = $service->getErrors();
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