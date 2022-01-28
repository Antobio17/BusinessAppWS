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
        $domain = $request->server->get('HTTP_HOST');
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $phoneNumber = $request->request->get('phoneNumber');
        $name = $request->request->get('name');
        $surname = $request->request->get('surname');

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
        if ($phoneNumber === NULL):
            $validationErrors[] = array(
                'field' => 'phoneNumber',
                'message' => 'The phoneNumber field cannot be empty'
            );
        endif;
        if ($name === NULL):
            $validationErrors[] = array(
                'field' => 'name',
                'message' => 'The name field cannot be empty'
            );
        endif;
        if ($surname === NULL):
            $validationErrors[] = array(
                'field' => 'surname',
                'message' => 'The surname field cannot be empty'
            );
        endif;

        $data = NULL;
        if (empty($validationErrors)):
            if ($this->getUserService()->setBusinessContext($domain)):
                $data = $this->getUserService()->signup($email, $password, $phoneNumber, $name, $surname);
            endif;
        endif;

        return $this->createJsonResponse_Creation($data, $validationErrors, $this->getUserService());
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}