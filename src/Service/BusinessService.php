<?php

namespace App\Service;

use App\Entity\AppError;
use App\Entity\User;
use App\Helper\ToolsHelper;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Interfaces\BusinessServiceInterface;
use Symfony\Component\Lock\LockFactory;

class BusinessService extends AppService implements BusinessServiceInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    /************************************************* CONSTRUCT **************************************************/

    /**
     * BusinessService construct.
     *
     * @param ManagerRegistry $doctrine Doctrine to manage the ORM.
     * @param TelegramService $telegramService Service of Telegram.
     * @param LockFactory $lockFactory The lock factory instance.
     * @param bool $testMode Boolean to set the Test Mode.
     */
    public function __construct(ManagerRegistry $doctrine, TelegramService $telegramService,
                                LockFactory     $lockFactory, bool $testMode = FALSE)
    {
        parent::__construct($doctrine, $telegramService, $lockFactory, $testMode);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array|null array|null
     */
    public function getBusinessHomeConfig(): ?array
    {
        $method = ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__);
        $business = $this->getBusiness();

        if ($business === NULL):
            $this->registerAppError_BusinessContextUndefined($method);
        else:
            $homeConfig = $this->getHomeConfigRepository()->findByBusiness($business);
            if ($homeConfig === NULL):
                $this->registerAppError(
                    $method, AppError::ERROR_BUSINESS_HOME_CONFIG_UNDEFINED,
                    'Error al recuperar configuración de Home: no existe configuración',
                );
            else:
                $postalAddress = $business->getPostalAddress();
                if ($postalAddress !== NULL):
                    $address = sprintf('%s', $postalAddress->getAddress());
                endif;

                $config = array(
                    'intro' => array(
                        'image' => $homeConfig->getImage()->__toArray(),
                        'bossName' => $homeConfig->getName(),
                        'description' => $homeConfig->getDescription()
                    ),
                    'social' => array(
                        'images' => $homeConfig->getSocialImagesAsArray()
                    ),
                    'services' => $homeConfig->getBusinessServicesAsArray(),
                    'contact' => array(
                        'businessName' => $business->getName(),
                        'address' => $address ?? NULL,
                        'businessHours' => $business->getShiftsAsArray(),
                        'phoneNumber' => $business->getPhoneNumber(),
                    )
                );

                if ($business->getEmail() !== NULL):
                    $config['contact']['email'] = $business->getEmail();
                endif;
            endif;
        endif;

        return $config ?? NULL;
    }

    /**
     * @inheritDoc
     * @return array|null array|null
     */
    public function getBusinessScheduleConfig(): ?array
    {
        $method = ToolsHelper::getStringifyMethod(get_class($this), __FUNCTION__);
        $business = $this->getBusiness();

        if ($business === NULL):
            $this->registerAppError_BusinessContextUndefined($method);
        else:
            $workers = $this->getUserRepository()->findByBusiness($business, TRUE);
            $config = array(
                'shifts' => $business->getShiftsAsArray(),
                'appointmentDuration' => $business->getAppointmentDuration(),
                'numWorkers' => count($workers),
                'isWorker' =>
                    $this->getUser() !== NULL && in_array(User::ROLE_WORKER, $this->getUser()->getRoles())
            );
        endif;

        return $config ?? NULL;
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}