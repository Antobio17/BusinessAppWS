<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Appointment;
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
        $status = $request->request->get(static::REQUEST_FIELD_STATUS);
        $startDate = $request->request->get(static::REQUEST_FIELD_START_DATE);
        $endDate = $request->request->get(static::REQUEST_FIELD_END_DATE);

        # Data Validation
        $validationErrors = $this->validateRequestStatusField($status, Appointment::getStatusChoices());
        $validationErrors = array_merge($validationErrors, $this->validateRequestDateFields(array(
            'startDate' => $startDate,
            'endDate' => $endDate,
        )));

        $data = NULL;
        if (empty($validationErrors)):
            $startDate = $startDate !== NULL ? date_create()->setTimestamp($startDate) : NULL;
            $endDate = $endDate !== NULL ? date_create()->setTimestamp($endDate) : NULL;
            if ($this->getAppointmentService()->setBusinessContext($domain)):
                $data = $this->getAppointmentService()->getBusinessAppointments($status, $startDate, $endDate);
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
        $status = $request->request->get(static::REQUEST_FIELD_STATUS);

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
        $status = $request->request->get(static::REQUEST_FIELD_STATUS);

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