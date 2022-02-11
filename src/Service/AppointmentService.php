<?php

namespace App\Service;

use App\Entity\Interfaces\AppointmentInterface;
use Exception;
use DateTime;
use DateInterval;
use App\Entity\User;
use App\Entity\AppError;
use App\Entity\Appointment;
use App\Helper\ToolsHelper;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Interfaces\AppointmentServiceInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AppointmentService extends AppService implements AppointmentServiceInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    /************************************************* CONSTRUCT **************************************************/

    /**
     * AppointmentService construct.
     *
     * @param ManagerRegistry $doctrine Doctrine to manage the ORM.
     * @param TelegramService $telegramService Service of Telegram.
     * @param bool $testMode Boolean to set the Test Mode.
     *
     */
    public function __construct(ManagerRegistry $doctrine, TelegramService $telegramService, bool $testMode = FALSE)
    {
        parent::__construct($doctrine, $telegramService, $testMode);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function getBusinessAppointments($status, ?DateTime $startDate = NULL, ?DateTime $endDate = NULL): ?array
    {
        # Parsing status
        if (is_numeric($status)):
            $status = (int)$status;
        elseif ($status !== NULL):
            $status = Appointment::getStatusChoices()[$status];
        endif;

        if ($this->getBusiness() !== NULL):
            $appointments = $this->getAppointmentRepository()->findByStatus(
                $this->getBusiness(), $status, NULL, FALSE, $startDate, $endDate
            );
        else:
            $appointments = NULL;
            $this->registerAppError_BusinessContextUndefined(
                ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__)
            );
        endif;

        return $appointments;
    }

    /**
     * @inheritDoc
     * @return array array
     */
    public function getUserAppointments($status, bool $isWorker = FALSE): ?array
    {
        # Parsing status
        if (is_numeric($status)):
            $status = (int)$status;
        elseif ($status !== NULL):
            $status = Appointment::getStatusChoices()[$status];
        endif;

        $appointments = NULL;
        if ($this->getBusiness() !== NULL && $this->getUser() !== NULL):
            $appointments = $this->getAppointmentRepository()->findByStatus(
                $this->getBusiness(), $status, $this->getUser(), $isWorker
            );
        elseif ($this->getBusiness() === NULL):
            $this->registerAppError_BusinessContextUndefined(
                ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__)
            );
        else:
            $this->registerAppError_UserContextUndefined(
                ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__)
            );
        endif;

        return $appointments;
    }

    /**
     * @inheritDoc
     * @return Appointment|null Appointment|null
     */
    public function bookUserAppointment(DateTime $bookingDateAt, ?string $userEmail = NULL): ?Appointment
    {
        $method = ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__);
        $user = NULL;
        $worker = NULL;

        # User validation
        $this->_validateUsersForBookAppointment($user, $worker, $userEmail);

        $appointment = NULL;
        if ($user !== NULL && empty($this->getErrors())):
            # BookingDate validations
            if (
                $bookingDateAt->format("H:m:s") < $this->getBusiness()->getOpensAt()
                && $bookingDateAt->format("H:m:s") > $this->getBusiness()->getClosesAt()
            ):
                $this->registerAppError(
                    $method,
                    AppError::ERROR_APPOINTMENT_BOOK_ERROR,
                    'Error al intentar reservar la cita: la hora de reserva está fuera de horario de trabajo',
                );
            elseif ($bookingDateAt < date_create()):
                $this->registerAppError(
                    $method,
                    AppError::ERROR_APPOINTMENT_BOOK_ERROR,
                    'Error al intentar reservar la cita: no se puede reservar una cita anterior a la actual',
                );
            elseif (($worker = $this->_getAvailableWorker($bookingDateAt, $worker)) === NULL):
                $this->registerAppError(
                    $method,
                    AppError::ERROR_APPOINTMENT_BOOK_ERROR,
                    'Error al intentar reservar la cita: trabajador no disponible',
                );
            endif;

            if ($worker !== NULL && empty($this->getErrors())):
                $appointment = new Appointment(
                    $this->getBusiness(),
                    $user,
                    $worker,
                    $bookingDateAt
                );
                $this->persistAndFlush($appointment);
            endif;
        endif;

        return $appointment;
    }

    /**
     * @inheritDoc
     * @return bool bool
     */
    public function cancelUserBookedAppointment(?string $userEmail = NULL): bool
    {
        $appointment = $this->_getAppointmentForCancellation($userEmail);

        $cancelled = FALSE;
        if ($appointment !== NULL):
            $appointment->setStatus(Appointment::STATUS_CANCELLED);
            $cancelled = $this->persistAndFlush($appointment);
        endif;

        return $cancelled;
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /**
     * Check if there is an available worker in the business for appointment booking.
     * If a worker is specified as a parameter, it is checked if that worker is available.
     *
     * @param DateTime $bookingDateAt Date of the book.
     * @param UserInterface|null $worker Worker in charge of the appointment.
     *
     * @return UserInterface|null UserInterface|null
     */
    protected function _getAvailableWorker(DateTime $bookingDateAt, ?UserInterface $worker = NULL): ?UserInterface
    {
        $appointmentDuration = $this->getBusiness()->getAppointmentDuration() - 1;
        if ($worker === NULL):
            $workers = $this->getUserRepository()->findByBusiness($this->getBusiness(), TRUE);
        else:
            $workers = array($worker);
        endif;

        try {
            foreach ($workers as $businessWorker):
                $startAt = date_create()->setTimestamp($bookingDateAt->getTimestamp());
                $startAt = $startAt->sub(new DateInterval(sprintf('PT%dM', $appointmentDuration)));
                $endAt = date_create()->setTimestamp($bookingDateAt->getTimestamp());
                $endAt = $endAt->add(new DateInterval(sprintf('PT%dM', $appointmentDuration)));
                if (
                    empty($this->getAppointmentRepository()->findByStatus(
                        $this->getBusiness(),
                        Appointment::STATUS_PENDING,
                        $businessWorker,
                        TRUE,
                        $startAt,
                        $endAt
                    ))
                ):
                    $availableWorker = $businessWorker;
                    break;
                endif;
            endforeach;
        } catch (Exception $e) {
            $this->registerAppError(
                ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__),
                AppError::ERROR_APPOINTMENT_BOOK_ERROR,
                'Error al calcular un intervalo para las comprobaciones de reserva de cita',
                $e->getCode(),
                $e->getMessage(),
                $e->getTrace()
            );
        }

        return $availableWorker ?? NULL;
    }

    /**
     * Validates the users of an appointment (client and worker) and returns them by reference.
     *
     * @param UserInterface|null $user The client of the appointment.
     * @param UserInterface|null $worker The worker of the appointment.
     * @param string|null $userEmail User's email in case the management is made by the worker.
     */
    protected function _validateUsersForBookAppointment(?UserInterface &$user, ?UserInterface &$worker, ?string $userEmail)
    {
        $method = ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__);

        if (in_array(User::ROLE_WORKER, $this->getUser()->getRoles()) && $userEmail !== NULL):
            $worker = $this->getUser();
            $user = $this->getUserRepository()->findByEmail($this->getBusiness(), $userEmail);
            if ($user === NULL):
                $this->registerAppError(
                    $method,
                    AppError::ERROR_APPOINTMENT_BOOK_USER_UNDEFINED,
                    'Error al intentar reservar una cita por trabajador: el email introducido no pertenece a ningún usuario'
                );
            endif;
        elseif (in_array(User::ROLE_WORKER, $this->getUser()->getRoles())):
            $this->registerAppError(
                $method,
                AppError::ERROR_APPOINTMENT_BOOK_USER_NOT_EXIST,
                'Error al intentar reservar una cita por trabajador: no se indicó el email de usuario'
            );
        else:
            $user = $this->getUser();
        endif;

        if ($user !== NULL):
            if (
                !empty($this->getAppointmentRepository()->findByStatus(
                    $this->getBusiness(), Appointment::STATUS_PENDING, $user
                ))
            ):
                $this->registerAppError(
                    $method,
                    AppError::ERROR_APPOINTMENT_BOOK_ALREADY_EXIST,
                    'Error al intentar reservar una cita: ya existe una cita pendiente para el usuario'
                );
            endif;
        endif;
    }

    /**
     * Get the appointment of a user to cancel it.
     *
     * @param string|null $userEmail User's email in case the management is made by the worker.
     *
     * @return AppointmentInterface|null AppointmentInterface|null
     */
    protected function _getAppointmentForCancellation(?string $userEmail): ?Appointment
    {
        $method = ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__);

        $appointment = NULL;
        $worker = NULL;
        if (in_array(User::ROLE_WORKER, $this->getUser()->getRoles()) && $userEmail !== NULL):
            $worker = $this->getUser();
            $user = $this->getUserRepository()->findByEmail($this->getBusiness(), $userEmail);
            if ($user === NULL):
                $this->registerAppError(
                    $method,
                    AppError::ERROR_APPOINTMENT_BOOK_USER_UNDEFINED,
                    'Error al intentar cancelar una cita por trabajador: el email introducido no pertenece a ningún usuario'
                );
            endif;
        elseif (in_array(User::ROLE_WORKER, $this->getUser()->getRoles())):
            $user = NULL;
            $this->registerAppError(
                $method,
                AppError::ERROR_APPOINTMENT_BOOK_USER_NOT_EXIST,
                'Error al intentar cancelar una cita por trabajador: no se indicó el email de usuario'
            );
        else:
            $user = $this->getUser();
        endif;

        if ($user !== NULL):
            if (
                !empty($appointments = $this->getAppointmentRepository()->findByStatus(
                    $this->getBusiness(), Appointment::STATUS_PENDING, $user,
                    FALSE, NULL, NULL, FALSE
                ))
            ):
                $appointment = $appointments[0];
                if (
                    $worker !== NULL
                    && $worker->getUserIdentifier() !== $appointment->getWorker()->getUserIdentifier()
                ):
                    $this->registerAppError(
                        $method,
                        AppError::ERROR_APPOINTMENT_BOOK_ALREADY_EXIST,
                        'Error al intentar cancelar una cita por trabajador: el trabajador asignado a la cita no corresponde con el actual'
                    );
                endif;
            else:
                $this->registerAppError(
                    $method,
                    AppError::ERROR_APPOINTMENT_BOOK_ALREADY_EXIST,
                    'Error al intentar cancelar una cita: el usuario no tiene citas reservadas para cancelar'
                );
            endif;
        endif;

        return $appointment;
    }

    /*********************************************** STATIC METHODS ***********************************************/

}