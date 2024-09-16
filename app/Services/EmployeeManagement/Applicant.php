<?php

namespace App\Services\EmployeeManagement;

class Applicant implements NonEmployeeInterface
{
    public function applyJob(): bool
    {
        return true;
    }
}