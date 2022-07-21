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

    public const REQUEST_SERVER_HTTP_REFERER = 'HTTP_REFERER';

    public const REQUEST_FIELD_STATUS = 'status';
    public const REQUEST_FIELD_START_DATE = 'startDate';
    public const REQUEST_FIELD_END_DATE = 'endDate';
    public const REQUEST_FIELD_OFFSET = 'offset';
    public const REQUEST_FIELD_LIMIT = 'limit';

    /************************************************* PROPERTIES *************************************************/

    /************************************************** ROUTING ***************************************************/

    /************************************************* CONSTRUCT **************************************************/

    /**
     * AppController construct.
     */
    public function __construct()
    {}

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function validateRequestNumericFields(array $requestFields): array
    {
        $validationErrors = array();
        foreach ($requestFields as $fieldName => $value):
            if ($value !== NULL && !is_numeric($value)):
                $validationErrors[] = array(
                    'field' => $fieldName,
                    'message' => sprintf('The %s field must be numeric', $fieldName)
                );
            endif;
        endforeach;

        return $validationErrors;
    }

    /**
     * @inheritDoc
     * @return array array
     */
    public function validateRequiredRequestFields(array $requestFields): array
    {
        $validationErrors = array();
        foreach ($requestFields as $fieldName => $value):
            if ($value === NULL):
                $validationErrors[] = array(
                    'field' => $fieldName,
                    'message' => sprintf('The %s field cannot be empty', $fieldName)
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
     * @param array $dates
     * @return array array
     */
    public function validateRequestDateFields(array $dates): array
    {
        $validationErrors = array();
        foreach ($dates as $fieldName => $date):
            if ($date !== NULL && !is_numeric($date)):
                $validationErrors[] = array(
                    'field' => $fieldName,
                    'message' => sprintf(
                        'El campo %s debe de ser de tipo entero (timestamp) o nulo',
                        $fieldName
                    )
                );
            endif;
        endforeach;

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