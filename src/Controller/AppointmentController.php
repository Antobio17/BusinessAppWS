<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Appointment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Traits\AppointmentServiceTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Interfaces\AppointmentServiceInterface;
use App\Controller\Interfaces\AppointmentControllerInterface;

class AppointmentController extends AppController implements AppointmentControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

    public const REQUEST_FIELD_BOOKING_DATE_AT = 'bookingDateAt';
    public const REQUEST_FIELD_USER_EMAIL = 'userEmail';
    public const REQUEST_FIELD_PHONE_NUMBER = 'phoneNumber';

    /************************************************* PROPERTIES *************************************************/

    use AppointmentServiceTrait;

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  AppointmentController constructor.
     *
     * @param AppointmentServiceInterface $appointmentService Service of Appointment.
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
    public function getBusinessAppointments(Request $request): JsonResponse
    {
        $domain = $request->server->get(static::REQUEST_SERVER_HTTP_REFERER);
        $status = $this->getParamFromRequest($request, static::REQUEST_FIELD_STATUS);
        $startDate = $this->getParamFromRequest($request, static::REQUEST_FIELD_START_DATE);
        $endDate = $this->getParamFromRequest($request, static::REQUEST_FIELD_END_DATE);

        # Data Validation
        $validationErrors = $this->validateRequestStatusField($status, Appointment::getStatusChoices());
        $validationErrors = array_merge($validationErrors, $this->validateRequestDateFields(array(
            static::REQUEST_FIELD_START_DATE => $startDate,
            static::REQUEST_FIELD_END_DATE => $endDate,
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
    public function getUserAppointments(Request $request): JsonResponse
    {
        $domain = $request->server->get(static::REQUEST_SERVER_HTTP_REFERER);
        $status = $this->getParamFromRequest($request, static::REQUEST_FIELD_STATUS);

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
    public function getWorkerAppointments(Request $request): JsonResponse
    {
        $domain = $request->server->get(static::REQUEST_SERVER_HTTP_REFERER);
        $status = $this->getParamFromRequest($request, static::REQUEST_FIELD_STATUS);

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

    /**
     * @Route("/api/book/user/appointment")
     *
     * @inheritDoc
     * @return JsonResponse JsonResponse
     */
    public function bookUserAppointment(Request $request): JsonResponse
    {
        $domain = $request->server->get(static::REQUEST_SERVER_HTTP_REFERER);
        $bookingDateAt = $this->getParamFromRequest($request, static::REQUEST_FIELD_BOOKING_DATE_AT);
        $phoneNumber = $this->getParamFromRequest($request, static::REQUEST_FIELD_PHONE_NUMBER);

        # Data Validation
        $validationErrors = $this->validateRequestDateFields(array(
            static::REQUEST_FIELD_BOOKING_DATE_AT => $bookingDateAt
        ));

        $appointment = NULL;
        if (empty($validationErrors)):
            if ($this->getAppointmentService()->setBusinessContext($domain)):
                $bookingDateAt = date_create()->setTimestamp($bookingDateAt);
                $appointment = $this->getAppointmentService()->bookUserAppointment($bookingDateAt, $phoneNumber);
            endif;
        endif;

        return $this->createJsonResponse_Creation(
            $appointment !== NULL ? $appointment->__toArray() : NULL,
            $validationErrors,
            $this->getAppointmentService()
        );
    }

    /**
     * @Route("/api/cancel/book/user/appointment")
     *
     * @inheritDoc
     * @return JsonResponse JsonResponse
     */
    public function cancelUserBookedAppointment(Request $request): JsonResponse
    {
        $domain = $request->server->get(static::REQUEST_SERVER_HTTP_REFERER);
        $userEmail = $this->getParamFromRequest($request, static::REQUEST_FIELD_USER_EMAIL);

        $cancelled = FALSE;
        if ($this->getAppointmentService()->setBusinessContext($domain)):
            $cancelled = $this->getAppointmentService()->cancelUserBookedAppointment($userEmail);
        endif;

        return $this->createJsonResponse($cancelled, array(), $this->getAppointmentService());
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}