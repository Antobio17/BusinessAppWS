<?php /** @noinspection PhpSuperClassIncompatibleWithInterfaceInspection */

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\NameTrait;
use Doctrine\ORM\Mapping\Column;
use App\Entity\Traits\DomainTrait;
use App\Repository\BusinessRepository;
use App\Entity\Traits\PhoneNumberTrait;
use App\Entity\Traits\PostalAddressTrait;
use App\Entity\Traits\BusinessConfigTrait;
use Doctrine\ORM\Mapping\AttributeOverride;
use App\Entity\Interfaces\BusinessInterface;
use Doctrine\ORM\Mapping\AttributeOverrides;

/**
 * Business entity
 *
 * @ORM\Entity(repositoryClass=BusinessRepository::class)
 * @AttributeOverrides({
 *      @AttributeOverride(name="name",
 *          column=@Column(
 *              name   = "name",
 *              unique = false,
 *              length = 1024
 *          )
 *      )
 * })
 */
class Business extends AbstractORM implements BusinessInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    use DomainTrait {
        DomainTrait::__construct as protected __domainConstruct;
        DomainTrait::__toArray as protected __domainToArray;
    }

    use NameTrait {
        NameTrait::__construct as protected __nameConstruct;
        NameTrait::__toArray as protected __nameToArray;
    }

    use PhoneNumberTrait {
        PhoneNumberTrait::__construct as protected __phoneNumberConstruct;
        PhoneNumberTrait::__toArray as protected __phoneNumberToArray;
    }

    use PostalAddressTrait {
        PostalAddressTrait::__construct as protected __postalAddressConstruct;
        PostalAddressTrait::__toArray as protected __postalAddressToArray;
    }

    use BusinessConfigTrait {
        BusinessConfigTrait::__construct as protected __configConstruct;
        BusinessConfigTrait::__toArray as protected __configToArray;
    }

    /************************************************* CONSTRUCT **************************************************/

    /**
     *  Business constructor.
     *
     * @param string $domain Domain to set in the entity.
     * @param string $name Name to set in the entity.
     * @param string $phoneNumber PhoneNumber to set in the entity.
     * @param PostalAddress $postalAddress PostalAddress to set in the entity.
     * @param string $opensAt The open date for the business.
     * @param string $closesAt The close date for the business.
     * @param int $appointmentDuration The duration of the appointments.
     *
     */
    public function __construct(string   $domain, string $name, string $phoneNumber, PostalAddress $postalAddress,
                                string $opensAt, string $closesAt, int $appointmentDuration = 60)
    {
        $this->__domainConstruct($domain);
        $this->__nameConstruct($name);
        $this->__phoneNumberConstruct($phoneNumber);
        $this->__postalAddressConstruct($postalAddress);
        $this->__configConstruct($opensAt, $closesAt, $appointmentDuration);
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
            $this->__domainToArray(),
            $this->__nameToArray(),
            $this->__phoneNumberToArray(),
            $this->__postalAddressToArray(),
            $this->__configToArray()
        );
    }

    /********************************************** PROTECTED METHODS *********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}