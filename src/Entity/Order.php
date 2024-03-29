<?php

namespace App\Entity;

use App\Entity\Interfaces\BusinessInterface;
use App\Entity\Traits\AmountTrait;
use App\Entity\Traits\ClientSecretTrait;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\DataTrait;
use App\Entity\Traits\PostalAddressTrait;
use App\Entity\Traits\SentAtTrait;
use App\Entity\Traits\StatusTrait;
use App\Entity\Traits\UUIDTrait;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrderRepository;
use App\Entity\Interfaces\OrderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Order entity.
 *
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 * @ORM\AssociationOverrides({
 *      @ORM\AssociationOverride(name="postalAddress",
 *          joinColumns=@ORM\JoinColumn(
 *              name                 = "postal_address_id",
 *              referencedColumnName = "id",
 *              nullable             = false
 *          )
 *      )
 * })
 */
class Order extends AbstractUserContext implements OrderInterface
{

    /************************************************* CONSTANTS **************************************************/

    public const STATUS_PENDING = 0;
    public const STATUS_PAID = 1;
    public const STATUS_PREPARING = 2;
    public const STATUS_CANCELLED = 3;
    public const STATUS_SENT = 4;
    public const STATUS_DELIVERED = 5;

    /************************************************* PROPERTIES *************************************************/

    use PostalAddressTrait {
        PostalAddressTrait::__construct as protected __postalAddressConstruct;
        PostalAddressTrait::__toArray as protected __postalAddressToArray;
    }

    use StatusTrait {
        StatusTrait::__construct as protected __statusConstruct;
        StatusTrait::__toArray as protected __statusToArray;
    }

    use AmountTrait {
        AmountTrait::__construct as protected __amountConstruct;
        AmountTrait::__toArray as protected __amountToArray;
    }

    use CreatedAtTrait {
        CreatedAtTrait::__construct as protected __createdAtConstruct;
        CreatedAtTrait::__toArray as protected __createdAtToArray;
    }

    use SentAtTrait {
        SentAtTrait::__construct as protected __sentAtConstruct;
        SentAtTrait::__toArray as protected __sentAtToArray;
    }

    use UUIDTrait {
        UUIDTrait::__construct as protected __uuidConstruct;
        UUIDTrait::__toArray as protected __uuidToArray;
    }

    use ClientSecretTrait {
        ClientSecretTrait::__construct as protected __clientSecretConstruct;
        ClientSecretTrait::__toArray as protected __clientSecretToArray;
    }

    use DataTrait {
        DataTrait::__construct as protected __dataConstruct;
        DataTrait::__toArray as protected __dataToArray;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  Order constructor.
     *
     * @param BusinessInterface $business Business to which the order belongs.
     * @param UserInterface $user User to which the order belongs.
     * @param PostalAddress $postalAddress The postal address to send the order.
     * @param float $amount Amount of the order.
     * @param string|null $uuid UUID of the payment order.
     * @param string|null $clientSecret ClientSecret of the payment order.
     * @param array $data Data related to the products ordered.
     * @param int $status Status of the order.
     * @param DateTime|null $createdAt Date of the creation of the order.
     * @param DateTime|null $sentAt Date when the order was sent.
     */
    public function __construct(BusinessInterface $business, UserInterface $user, PostalAddress $postalAddress,
                                float             $amount = 0.0, ?string $uuid = NULL, ?string $clientSecret = NULL,
                                array             $data = array(), int $status = 0, ?DateTime $createdAt = NULL,
                                ?DateTime $sentAt = NULL)
    {
        parent::__construct($business, $user);

        $this->__postalAddressConstruct($postalAddress);
        $this->__uuidConstruct($uuid);
        $this->__clientSecretConstruct($clientSecret);
        $this->__statusConstruct($status);
        $this->__amountConstruct($amount);
        $this->__dataConstruct($data);
        $this->__createdAtConstruct($createdAt ?? date_create());
        $this->__sentAtConstruct($sentAt);
    }

    /******************************************** GETTERS AND SETTERS *********************************************/

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public function __toArray(): array
    {
        return array_merge(
            parent::__toArray(),
            $this->__uuidToArray(),
            $this->__clientSecretToArray(),
            $this->__statusToArray(),
            $this->__amountToArray(),
            $this->__createdAtToArray(),
            $this->__sentAtToArray(),
            $this->__dataToArray(),
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return array array
     */
    public static function getStatusChoices(): array
    {
        return array(
            'Pendiente' => static::STATUS_PENDING,
            'Pagado' => static::STATUS_PAID,
            'En Preparación' => static::STATUS_PREPARING,
            'Cancelado' => static::STATUS_CANCELLED,
            'Enviado' => static::STATUS_SENT,
            'Entregado' => static::STATUS_DELIVERED,
        );
    }

}