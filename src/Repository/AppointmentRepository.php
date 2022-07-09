<?php

namespace App\Repository;

use DateTime;
use App\Entity\Appointment;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use App\Entity\Interfaces\BusinessInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\Interfaces\AppointmentRepositoryInterface;

/**
 * @method Appointment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appointment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appointment[]    findAll()
 * @method Appointment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppointmentRepository extends AppRepository implements AppointmentRepositoryInterface
{

    /************************************************* CONSTRUCT **************************************************/

    /**
     * AppointmentRepository constructor.
     *
     * @param ManagerRegistry $registry Object managers for a Doctrine persistence layer ManagerRegistry class.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appointment::class);
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return Appointment Appointment
     */
    public function findByBookingDate(BusinessInterface $business, DateTime $bookingDateAt,
                                      ?UserInterface    $user = NULL, bool $isWorker = FALSE): ?Appointment
    {
        $alias = 'app';

        $queryBuilder = $this->createQueryBuilder($alias)
            ->andWhere(sprintf('%s.business = :business', $alias))
            ->setParameter('business', $business->getID())
            ->andWhere(sprintf('%s.bookingDateAt = :bookingDateAt', $alias))
            ->setParameter('bookingDateAt', $bookingDateAt);

        if ($user !== NULL):
            if ($isWorker):
                $property = 'worker';
            else:
                $property = 'user';
            endif;
            /** @noinspection PhpPossiblePolymorphicInvocationInspection */
            $queryBuilder->andWhere(sprintf('%s.%s = :%s', $alias, $property, $property))
                ->setParameter($property, $user->getID());
        endif;

        try {
            $appointment = $queryBuilder->orderBy(sprintf('%s.id', $alias), 'DESC')
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
        }

        return $appointment ?? NULL;
    }

    /*********************************************** STATIC METHODS ***********************************************/

}