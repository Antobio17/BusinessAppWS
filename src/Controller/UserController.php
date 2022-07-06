<?php

namespace App\Controller;

use App\Service\Traits\UserServiceTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Interfaces\UserServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\Interfaces\UserControllerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;

class UserController extends AppController implements UserControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

    public const REQUEST_FIELD_EMAIL = 'email';
    public const REQUEST_FIELD_PASSWORD = 'password';
    public const REQUEST_FIELD_PHONENUMBER = 'phoneNumber';
    public const REQUEST_FIELD_NAME = 'name';
    public const REQUEST_FIELD_SURNAME = 'surname';
    public const REQUEST_FIELD_ADDRESS = 'address';
    public const REQUEST_FIELD_NEIGHBORHOOD = 'neighborhood';
    public const REQUEST_FIELD_POSTAL_CODE = 'postalCode';
    public const REQUEST_FIELD_POPULATION = 'population';
    public const REQUEST_FIELD_PROVINCE = 'province';
    public const REQUEST_FIELD_STATE = 'state';
    public const REQUEST_FIELD_POSTAL_ADDRESS_ID = 'postalAddressID';

    /************************************************* PROPERTIES *************************************************/

    use UserServiceTrait;

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  UserController constructor.
     *
     * @param UserServiceInterface $userService Service of User.
     *
     */
    public function __construct(UserServiceInterface $userService)
    {
        parent::__construct();

        $this->setUserService($userService);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /************************************************** ROUTING ***************************************************/

    /**
     * @Route("/api/signup")
     *
     * @inheritDoc
     * @return JsonResponse JsonResponse
     */
    public function signup(Request $request): Response
    {
        $domain = $request->server->get('HTTP_HOST');
        $email = $request->request->get(static::REQUEST_FIELD_EMAIL);
        $password = $request->request->get(static::REQUEST_FIELD_PASSWORD);
        $phoneNumber = $request->request->get(static::REQUEST_FIELD_PHONENUMBER);
        $name = $request->request->get(static::REQUEST_FIELD_NAME);
        $surname = $request->request->get(static::REQUEST_FIELD_SURNAME);

        # Data Validation
        $validationErrors = $this->validateRequiredRequestFields(array(
            static::REQUEST_FIELD_EMAIL => $email,
            static::REQUEST_FIELD_PASSWORD => $password,
            static::REQUEST_FIELD_PHONENUMBER => $phoneNumber,
            static::REQUEST_FIELD_NAME => $name,
            static::REQUEST_FIELD_SURNAME => $surname,
        ));

        $data = NULL;
        if (empty($validationErrors)):
            if ($this->getUserService()->setBusinessContext($domain)):
                $data = $this->getUserService()->signup($email, $password, $phoneNumber, $name, $surname);
            endif;
        endif;

        return $this->createJsonResponse_Creation($data, $validationErrors, $this->getUserService());
    }

    /**
     * @Route("/api/signin")
     *
     * @inheritDoc
     * @return JsonResponse JsonResponse
     */
    public function signin(Request $request): Response
    {
        $domain = $request->server->get('HTTP_HOST');
        $email = $request->request->get(static::REQUEST_FIELD_EMAIL);
        $password = $request->request->get(static::REQUEST_FIELD_PASSWORD);

        # Data Validation
        $validationErrors = $this->validateRequiredRequestFields(array(
            static::REQUEST_FIELD_EMAIL => $email,
            static::REQUEST_FIELD_PASSWORD => $password,
        ));

        $data = NULL;
        if (empty($validationErrors)):
            if ($this->getUserService()->setBusinessContext($domain)):
                $data = $this->getUserService()->signin($email, $password);
            endif;
        endif;

        return $this->createJsonResponse($data, $validationErrors, $this->getUserService());
    }

    /**
     * @Route("/api/user/create/address")
     *
     * @inheritDoc
     * @return JsonResponse JsonResponse
     */
    public function createPostalAddress(Request $request): Response
    {
        $domain = $request->server->get('HTTP_HOST');
        $name = $request->request->get(static::REQUEST_FIELD_NAME);
        $address = $request->request->get(static::REQUEST_FIELD_ADDRESS);
        $neighborhood = $request->request->get(static::REQUEST_FIELD_NEIGHBORHOOD);
        $postalCode = $request->request->get(static::REQUEST_FIELD_POSTAL_CODE);
        $population = $request->request->get(static::REQUEST_FIELD_POPULATION);
        $province = $request->request->get(static::REQUEST_FIELD_PROVINCE);
        $state = $request->request->get(static::REQUEST_FIELD_STATE);
        $postalAddressID = $request->request->get(static::REQUEST_FIELD_POSTAL_ADDRESS_ID);

        # Data Validation
        $validationErrors = array_merge(
            $this->validateRequiredRequestFields(array(
                static::REQUEST_FIELD_NAME => $name,
                static::REQUEST_FIELD_ADDRESS => $address,
                static::REQUEST_FIELD_POSTAL_CODE => $postalCode,
                static::REQUEST_FIELD_POPULATION => $population,
                static::REQUEST_FIELD_PROVINCE => $province,
                static::REQUEST_FIELD_STATE => $state,
            )),
            $this->validateRequestNumericFields(array(
                static::REQUEST_FIELD_POSTAL_ADDRESS_ID => $postalAddressID,
            ))
        );

        $data = NULL;
        if (empty($validationErrors)):
            if ($this->getUserService()->setBusinessContext($domain)):
                $postalAddressID = $postalAddressID !== NULL ? (int)$postalAddressID : NULL;
                $data = $this->getUserService()->managePostalAddress(
                    $name, $address, $neighborhood, $postalCode, $population, $province, $state, $postalAddressID
                );
            endif;
        endif;

        return $this->createJsonResponse($data, $validationErrors, $this->getUserService());
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}