<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Traits\AppointmentServiceTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Interfaces\AppointmentServiceInterface;
use App\Controller\Interfaces\AppointmentControllerInterface;

class AppointmentController extends AppController implements AppointmentControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

    public const REQUEST_FIELD_APPOINTMENT_STATUS = 'status';

    /************************************************* PROPERTIES *************************************************/

    use AppointmentServiceTrait;

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  AppointmentController constructor.
     *
     * @param AppointmentServiceInterface $appointmentService Service of User.
     *
     */
    public function __construct(AppointmentServiceInterface $appointmentService)
    {
        parent::__construct();

        $this->setAppointmentService($appointmentService);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /************************************************** ROUTING ***************************************************/

    /**
     * @Route("/api/get/business/appointments")
     *
     * @inheritDoc
     * @return JsonResponse JsonResponse
     */
    public function getBusinessAppointments(Request $request): Response
    {
        $domain = $request->server->get('HTTP_HOST');
        $status = $request->request->get(static::REQUEST_FIELD_APPOINTMENT_STATUS);

        # Data Validation
        $validationErrors = $this->validateRequestStatusField($status, Appointment::getStatusChoices());

        $data = NULL;
        if (empty($validationErrors)):
            if ($this->getAppointmentService()->setBusinessContext($domain)):
                $data = $this->getAppointmentService()->getBusinessAppointments($status);
            endif;
        endif;

        return $this->createJsonResponse($data, $validationErrors, $this->getAppointmentService());
    }

    /**
     * @Route("/api/get/user/appointments")
     *
     * @inheritDoc
     * @return JsonResponse JsonResponse
     */
    public function getUserAppointments(Request $request): Response
    {
        $domain = $request->server->get('HTTP_HOST');
        $status = $request->request->get(static::REQUEST_FIELD_APPOINTMENT_STATUS);

        # Data Validation
        $validationErrors = $this->validateRequestStatusField($status, Appointment::getStatusChoices());

        $data = NULL;
        if (empty($validationErrors)):
            if ($this->getAppointmentService()->setBusinessContext($domain)):
                $data = $this->getAppointmentService()->getUserAppointments($status);
            endif;
        endif;

        return $this->createJsonResponse($data, $validationErrors, $this->getAppointmentService());
    }

    /**
     * @Route("/api/get/worker/appointments")
     *
     * @inheritDoc
     * @return JsonResponse JsonResponse
     */
    public function getWorkerAppointments(Request $request): Response
    {
        $domain = $request->server->get('HTTP_HOST');
        $status = $request->request->get(static::REQUEST_FIELD_APPOINTMENT_STATUS);

        # Data Validation
        $validationErrors = $this->validateRequestStatusField($status, Appointment::getStatusChoices());

        $data = NULL;
        if (empty($validationErrors)):
            if ($this->getAppointmentService()->setBusinessContext($domain)):
                $data = $this->getAppointmentService()->getUserAppointments(
                    $status, in_array(User::ROLE_WORKER, $this->getUser()->getRoles())
                );
            endif;
        endif;

        return $this->createJsonResponse($data, $validationErrors, $this->getAppointmentService());
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}