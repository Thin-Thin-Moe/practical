<?php

namespace App\Services\InternetServiceProvider;

interface InternetServiceProviderInterface
{
    public function setMonth(int $month);

    public function calculateTotalAmount(): float|int;
}