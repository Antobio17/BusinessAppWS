<?php

namespace App\Service;

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

        # User validations
        if (in_array(User::ROLE_WORKER, $this->getUser()->getRoles()) && $userEmail !== NULL):
            $worker = $this->getUser();
            $user = $this->getUserRepository()->findByEmail($this->getBusiness(), $userEmail);
            if ($user === NULL):
                $this->registerAppError(
                    $method,
                    AppError::ERROR_APPOINTMENT_BOOK_USER_UNDEFINED,
                    'Error al intentar reservar una cita por trabajador: 
                    el email introducido no pertenece a ningún usuario'
                );
            endif;
        elseif (in_array(User::ROLE_WORKER, $this->getUser()->getRoles())):
            $this->registerAppError(
                $method,
                AppError::ERROR_APPOINTMENT_BOOK_USER_NOT_EXIST,
                'Error al intentar reservar una cita por trabajador: 
                no se indicó el email de usuario'
            );
        else:
            $user = $this->getUser();
            if (
                !empty($this->getAppointmentRepository()->findByStatus(
                    $this->getBusiness(), Appointment::STATUS_PENDING, $this->getUser()
                ))
            ):
                $this->registerAppError(
                    $method,
                    AppError::ERROR_APPOINTMENT_BOOK_ALREADY_EXIST,
                    'Error al intentar reservar una cita: 
                    ya existe una cita pendiente para el usuario'
                );
            endif;
        endif;

        $appointment = NULL;
        if ($user !== NULL):
            # BookingDate validations
            if (
                $bookingDateAt->format("h:m:s") < $this->getBusiness()->getOpensAt()
                || $bookingDateAt->format("h:m:s") > $this->getBusiness()->getClosesAt()
            ):
                $this->registerAppError(
                    $method,
                    AppError::ERROR_APPOINTMENT_BOOK_ERROR,
                    'Error al intentar reservar la cita: 
                        la hora de reserva está fuera de horario de trabajo',
                );
            elseif (($worker = $this->_getAvailableWorker($bookingDateAt, $worker)) === NULL):
                $this->registerAppError(
                    $method,
                    AppError::ERROR_APPOINTMENT_BOOK_ERROR,
                    'Error al intentar reservar la cita: trabajador no disponible',
                );
            endif;

            if ($worker !== NULL):
                $appointment = new Appointment(
                    $this->getBusiness(),
                    $user,
                    $worker,
                    $bookingDateAt
                );
                $this->persistAndFlush($appointment);
            endif;
        endif;

        return empty($this->getErrors()) ? $appointment : NULL;
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
            $workers = $this->getBusiness()->getWorkers();
        else:
            $workers = array($worker);
        endif;

        try {
            foreach ($workers as $businessWorker):
                if (
                    empty($this->getAppointmentRepository()->findByStatus(
                        $this->getBusiness(),
                        NULL,
                        $businessWorker,
                        TRUE,
                        $bookingDateAt->sub(new DateInterval(sprintf('PT%dM', $appointmentDuration))),
                        $bookingDateAt->add(new DateInterval(sprintf('PT%dM', $appointmentDuration)))
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

    /*********************************************** STATIC METHODS ***********************************************/

}