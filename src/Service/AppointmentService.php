<?php

namespace App\Service;

use App\Entity\AppError;
use App\Entity\Appointment;
use App\Entity\User;
use App\Helper\ToolsHelper;
use App\Service\Interfaces\AppointmentServiceInterface;
use App\Service\Interfaces\UserServiceInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
    public function getBusinessAppointments($status): ?array
    {
        if (is_numeric($status)):
            $status = (int)$status;
        elseif ($status !== NULL):
            $status = Appointment::getStatusChoices()[$status];
        endif;

        if ($this->getBusiness() !== NULL):
            $appointments = $this->getAppointmentRepository()->findByStatus($this->getBusiness(), $status);
        else:
            $appointments = NULL;
            $this->registerAppError_BusinessContextNotSet(
                ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__)
            );
        endif;

        return $appointments;
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}