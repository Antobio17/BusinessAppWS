<?php

namespace App\Controller;

use App\Service\Traits\UserServiceTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Interfaces\UserServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\Interfaces\UserControllerInterface;

class UserController extends AppController implements UserControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

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
        $email = $request->get('email');
        $password = $request->get('password');
        $phoneNumber = $request->get('phoneNumber');
        $name = $request->get('name');
        $surname = $request->get('surname');

        # Data Validation
        $validationErrors = array();
        if ($email === NULL):
            $validationErrors[] = array(
                'field' => 'email',
                'message' => 'The email field cannot be empty'
            );
        endif;
        if ($password === NULL):
            $validationErrors[] = array(
                'field' => 'password',
                'message' => 'The password field cannot be empty'
            );
        endif;

        $data = NULL;
        if (empty($errors)):
            $data = $this->getUserService()->signup($email, $password, $phoneNumber, $name, $surname);
        endif;

        return $this->createJsonResponse_Creation($data, $validationErrors, $this->getUserService());
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}