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
     * @inheritDoc
     * @return array array
     */
    public function validateRequiredRequestFields(array $requestFields): array
    {
        $validationErrors = array();
        foreach ($requestFields as $key => $value):
            if ($value === NULL):
                $validationErrors[] = array(
                    'field' => $key,
                    'message' => sprintf('The %s field cannot be empty', $key)
                );
            endif;
        endforeach;

        return $validationErrors;
    }

    /**
     * @inheritDoc
     * @return array array
     */
    public function validateRequestStatusField($status, array $statusChoices): array
    {
        $validationErrors = array();

        if (
            $status !== NULL
            && ((is_numeric($status) && !in_array((int)$status, $statusChoices))
            || (
                !is_numeric($status)
                && !in_array(strtolower($status), array_keys(array_change_key_case($statusChoices)))
            ))
        ):
            $validationErrors[] = array(
                'field' => 'status',
                'message' => sprintf('The status %s does not exist', $status)
            );
        endif;

        return $validationErrors;
    }

    /**
     * @inheritDoc
     * @return Response Response
     */
    public function createJsonResponse_Creation($data, array $validationErrors,
                                                AppServiceInterface $service): Response
    {
        return $this->createJsonResponse($data, $validationErrors, $service, Response::HTTP_CREATED);
    }

    /**
     * @inheritDoc
     * @return Response Response
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

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}