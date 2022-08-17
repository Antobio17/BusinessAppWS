<?php

namespace App\Controller\Interfaces;

use App\Service\Interfaces\AppServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

interface AppControllerInterface
{

    /************************************************** ROUTING ***************************************************/

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Validates the fields of the request passed by parameters as an array of key => value.
     *
     *      return array(
     *          array(
     *              'field' => $key,
     *              'message' => sprintf('The %s field must be integer', $key)
     *          )
     *      )
     *
     * @param array $requestFields The array of fields to validate.
     *
     * @return array array
     */
    public function validateRequestNumericFields(array $requestFields): array;

    /**
     * Validates the fields of the request passed by parameters as an array of key => value.
     *
     *      return array(
     *          array(
     *              'field' => $key,
     *              'message' => sprintf('The %s field cannot be empty', $key)
     *          )
     *      )
     *
     * @param array $requestFields The array of fields to validate.
     *
     * @return array array
     */
    public function validateRequiredRequestFields(array $requestFields): array;

    /**
     * Validates the fields of the request passed by parameters as an array of key => value.
     *
     *      return array(
     *          array(
     *              'field' => 'status',
     *              'message' => sprintf('The status %s does not exist', $value)
     *          )
     *      )
     *
     * @param mixed $status The status from the request.
     * @param array $statusChoices The valid status of the entity.
     *
     * @return array array
     */
    public function validateRequestStatusField(array $status, array $statusChoices): array;

    /**
     * Validates the fields of the request passed by parameters as an array of key => value.
     *
     *      return array(
     *          array(
     *              'field' => $key,
     *              'message' => sprintf(
     *                  'El campo %s debe de ser de tipo entero (timestamp) o nulo',$fieldName
     *              )
     *          )
     *      )
     *
     * @param array $dates The valid status of the entity.
     *
     * @return array array
     */
    public function validateRequestDateFields(array $dates): array;

    /**
     * Gets the param value from the request passed or null if it not exists.
     *
     * @param Request $request Request of the route.
     * @param string $paramKey Key to search the param value.
     *
     * @return mixed|null mixed|null
     */
    public function getParamFromRequest(Request $request, string $paramKey);

    /**
     * Creates a Json response for the WebService.
     * If the process is successful it will return the creation code 201.
     *
     * @param mixed $data The data of the response.
     * @param array $validationErrors The validation errors to add to the response.
     * @param AppServiceInterface $service The service used in the process.
     *
     * @return JsonResponse JsonResponse
     */
    public function createJsonResponse_Creation($data, array $validationErrors,
                                                AppServiceInterface $service): JsonResponse;

    /**
     * Creates a Json response for the WebService.
     * If the process is successful it will return the creation code 202.
     *
     * @param mixed $data The data of the response.
     * @param array $validationErrors The validation errors to add to the response.
     * @param AppServiceInterface $service The service used in the process.
     *
     * @return JsonResponse JsonResponse
     */
    public function createJsonResponse_Put($data, array $validationErrors,
                                           AppServiceInterface $service): JsonResponse;

    /**
     * Creates a Json response for the WebService.
     * It will return the code passed.
     *
     * @param mixed $data The data of the response.
     * @param array $validationErrors The validation errors to add to the response.
     * @param AppServiceInterface $service The service used in the process.
     * @param int $code The code to return.
     *
     * @return JsonResponse JsonResponse
     */
    public function createJsonResponse($data, array $validationErrors, AppServiceInterface $service,
                                       int $code = 200): JsonResponse;

    /*********************************************** STATIC METHODS ***********************************************/

}