<?php

namespace App\Controller\Interfaces;

use App\Service\Interfaces\AppServiceInterface;
use Symfony\Component\HttpFoundation\Response;

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
     * Creates a Json response for the WebService.
     * If the process is successful it will return the creation code 201.
     *
     * @param mixed $data The data of the response.
     * @param array $validationErrors The validation errors to add to the response.
     * @param AppServiceInterface $service The service used in the process.
     *
     * @return Response Response
     */
    public function createJsonResponse_Creation($data, array $validationErrors,
                                                AppServiceInterface $service): Response;

    /**
     * Creates a Json response for the WebService.
     * It will return the code passed.
     *
     * @param mixed $data The data of the response.
     * @param array $validationErrors The validation errors to add to the response.
     * @param AppServiceInterface $service The service used in the process.
     * @param int $code The code to return.
     *
     * @return Response Response
     */
    public function createJsonResponse($data, array $validationErrors, AppServiceInterface $service,
                                       int $code = 200): Response;

    /*********************************************** STATIC METHODS ***********************************************/

}