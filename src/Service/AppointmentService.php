<?php

namespace App\Service;

use DateTime;
use App\Entity\Appointment;
use App\Helper\ToolsHelper;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Interfaces\AppointmentServiceInterface;

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

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}