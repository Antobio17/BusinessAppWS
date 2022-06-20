<?php

namespace App\Tests\Appointments;

use App\Entity\AppError;
use App\Tests\AppTestCase;

class BookAppointmentTest extends AppTestCase
{

    /************************************************* PROPERTIES *************************************************/

    public function test_bookSuccess()
    {
        $this->setUp();
        $appError = new AppError(1, 'prueba', 'prueba');
        $this->persistAndFlush($appError);
        $errors = $this->getAppErrorRepository()->findAll();
        $this->tearDown();

        $this->assertSame(1, count($errors));
    }

}