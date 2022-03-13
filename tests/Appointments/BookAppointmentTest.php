<?php

namespace App\Tests\Appointments;

use App\Entity\AppError;
use App\Service\AppService;
use App\Service\Traits\RepositoriesTrait;
use Doctrine\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;

class BookAppointmentTest extends TestCase
{

    use RepositoriesTrait;

    public function test_bookSuccess(ObjectManager $entityManager)
    {
        $appError = new AppError(1, 'probando', 'probando');
        $entityManager->persist($appError);
        $entityManager->flush();

        $newError = $this->getAppErrorRepository()->findAll();

        $this->assertTrue(count($newError) === 1);
    }
}