<?php /** @noinspection DuplicatedCode */

namespace App\Controller;

use App\Controller\Interfaces\UserControllerInterface;
use App\Entity\AppError;
use App\Helper\ToolsHelper;
use App\Service\Interfaces\UserServiceInterface;
use App\Service\Traits\UserServiceTrait;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AppController implements UserControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

    public const REQUEST_FIELD_USER_ID = 'userID';
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
    public const REQUEST_FIELD_TOKEN = 'token';
    public const REQUEST_FIELD_BUSINESS_ID = 'business';

    public const COOKIE_LOGIN_EXPIRATION = 259200;

    public const PATH_VERIFY_USER = '/verify/user';

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
     * @Route("/verify/user")
     *
     * @inheritDoc
     * @return Response Response
     */
    public function verifyUser(Request $request): Response
    {
        $email = $this->getParamFromRequest($request, static::REQUEST_FIELD_EMAIL);
        $token = $this->getParamFromRequest($request, static::REQUEST_FIELD_TOKEN);
        $businessID = $this->getParamFromRequest($request, static::REQUEST_FIELD_BUSINESS_ID);

        $validationErrors = array_merge(
            $this->validateRequiredRequestFields(array(
                static::REQUEST_FIELD_EMAIL => $email,
                static::REQUEST_FIELD_TOKEN => $token,
                static::REQUEST_FIELD_BUSINESS_ID => $businessID,
            )),
            $this->validateRequestNumericFields(array(
                static::REQUEST_FIELD_BUSINESS_ID => $businessID,
            ))
        );

        if (empty($validationErrors)):
            $url = $this->getUserService()->verifyUser((int)$businessID, $email, $token);
        endif;

        if (isset($url)):
            $response = $this->redirect($url);
        else:
            $response = $this->createJsonResponse(NULL, $validationErrors, $this->getUserService());
        endif;

        return $response;
    }

    /**
     * @Route("/api/signup")
     *
     * @inheritDoc
     * @return JsonResponse JsonResponse
     */
    public function signup(Request $request): JsonResponse
    {
        $domain = $request->server->get(static::REQUEST_SERVER_HTTP_REFERER);
        $email = $this->getParamFromRequest($request, static::REQUEST_FIELD_EMAIL);
        $password = $this->getParamFromRequest($request, static::REQUEST_FIELD_PASSWORD);
        $phoneNumber = $this->getParamFromRequest($request, static::REQUEST_FIELD_PHONENUMBER);
        $name = $this->getParamFromRequest($request, static::REQUEST_FIELD_NAME);
        $surname = $this->getParamFromRequest($request, static::REQUEST_FIELD_SURNAME);

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
    public function signin(Request $request): JsonResponse
    {
        $domain = $request->server->get(static::REQUEST_SERVER_HTTP_REFERER);
        $email = $this->getParamFromRequest($request, static::REQUEST_FIELD_EMAIL);
        $password = $this->getParamFromRequest($request, static::REQUEST_FIELD_PASSWORD);

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

        $response = $this->createJsonResponse($data, $validationErrors, $this->getUserService());

        if ($data !== NULL && isset($data['token'])):
            $response = $this->_setJWTCookiesResponse($data['token'], $response);
        endif;

        return $response;
    }

    /**
     * @Route("/api/user/create/address")
     *
     * @inheritDoc
     * @return JsonResponse JsonResponse
     */
    public function createPostalAddress(Request $request): JsonResponse
    {
        $domain = $request->server->get(static::REQUEST_SERVER_HTTP_REFERER);
        $name = $this->getParamFromRequest($request, static::REQUEST_FIELD_NAME);
        $address = $this->getParamFromRequest($request, static::REQUEST_FIELD_ADDRESS);
        $neighborhood = $this->getParamFromRequest($request, static::REQUEST_FIELD_NEIGHBORHOOD);
        $postalCode = $this->getParamFromRequest($request, static::REQUEST_FIELD_POSTAL_CODE);
        $population = $this->getParamFromRequest($request, static::REQUEST_FIELD_POPULATION);
        $province = $this->getParamFromRequest($request, static::REQUEST_FIELD_PROVINCE);
        $state = $this->getParamFromRequest($request, static::REQUEST_FIELD_STATE);
        $postalAddressID = $this->getParamFromRequest($request, static::REQUEST_FIELD_POSTAL_ADDRESS_ID);

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

    /**
     * @Route("/api/user/delete/address")
     *
     * @inheritDoc
     * @return JsonResponse JsonResponse
     */
    public function deletePostalAddress(Request $request): JsonResponse
    {
        $domain = $request->server->get(static::REQUEST_SERVER_HTTP_REFERER);
        $postalAddressID = $this->getParamFromRequest($request, static::REQUEST_FIELD_POSTAL_ADDRESS_ID);

        # Data Validation
        $validationErrors = array_merge(
            $this->validateRequiredRequestFields(array(
                static::REQUEST_FIELD_POSTAL_ADDRESS_ID => $postalAddressID,
            )),
            $this->validateRequestNumericFields(array(
                static::REQUEST_FIELD_POSTAL_ADDRESS_ID => $postalAddressID,
            ))
        );

        $data = NULL;
        if (empty($validationErrors)):
            if ($this->getUserService()->setBusinessContext($domain)):
                $postalAddressID = (int)$postalAddressID;
                $data = $this->getUserService()->deletePostalAddress($postalAddressID);
            endif;
        endif;

        return $this->createJsonResponse_Put($data, $validationErrors, $this->getUserService());
    }

    /**
     * @Route("/api/get/user/data")
     *
     * @inheritDoc
     * @return JsonResponse JsonResponse
     */
    public function getUserData(Request $request): JsonResponse
    {
        $domain = $request->server->get(static::REQUEST_SERVER_HTTP_REFERER);

        if ($this->getUserService()->setBusinessContext($domain)):
            $data = $this->getUserService()->getUserData();
        endif;

        return $this->createJsonResponse($data ?? NULL, array(), $this->getUserService());
    }

    /**
     * @Route("/api/user/update")
     *
     * @inheritDoc
     * @return JsonResponse JsonResponse
     */
    public function updateUserData(Request $request): JsonResponse
    {
        $domain = $request->server->get(static::REQUEST_SERVER_HTTP_REFERER);
        $email = $this->getParamFromRequest($request, static::REQUEST_FIELD_EMAIL);
        $password = $this->getParamFromRequest($request, static::REQUEST_FIELD_PASSWORD);
        $phoneNumber = $this->getParamFromRequest($request, static::REQUEST_FIELD_PHONENUMBER);
        $name = $this->getParamFromRequest($request, static::REQUEST_FIELD_NAME);
        $surname = $this->getParamFromRequest($request, static::REQUEST_FIELD_SURNAME);

        # Data Validation
        $validationErrors = $this->validateRequiredRequestFields(array(
            static::REQUEST_FIELD_EMAIL => $email,
            static::REQUEST_FIELD_PHONENUMBER => $phoneNumber,
            static::REQUEST_FIELD_NAME => $name,
            static::REQUEST_FIELD_SURNAME => $surname,
        ));

        $data = NULL;
        if (empty($validationErrors)):
            if ($this->getUserService()->setBusinessContext($domain)):
                $data = $this->getUserService()->updateUserData($email, $phoneNumber, $name, $surname, $password);
            endif;
        endif;

        return $this->createJsonResponse_Put($data, $validationErrors, $this->getUserService());
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /********************************************** PROTECTED METHODS *********************************************/

    /**
     * @param string $token
     * @param JsonResponse $response
     * @return JsonResponse
     */
    protected function _setJWTCookiesResponse(string $token, JsonResponse $response): JsonResponse
    {
        $tokenSplit = explode('.', $token);

        if (count($tokenSplit) === 3):
            $response->headers->setCookie(new Cookie(
                'jwt_hp',
                sprintf('%s.%s', $tokenSplit[0], $tokenSplit[1]),
                time() + static::COOKIE_LOGIN_EXPIRATION,
                '/',
                null,
                false,
                false
            ));
            $response->headers->setCookie(new Cookie(
                'jwt_s',
                $tokenSplit[2],
                0,
                '/',
                null,
                false,
                true
            ));
        else:
            $this->getUserService()->registerAppError(
                ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__),
                AppError::ERROR_JWT_SPLIT_TOKEN,
                sprintf('Error al establecer las cookies de JWT: Token %s no válido.', $token)
            );
        endif;

        return $response;
    }

    /*********************************************** STATIC METHODS ***********************************************/

}