<?php

namespace App\Services\EmployeeManagement;

class Staff implements EmployeeInterface
{
    public function salary(): int
    {
        return 200;
    }
}