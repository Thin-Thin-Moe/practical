<?php

namespace App\Services\InternetServiceProvider;

class Ooredoo extends InternetServiceProviderAbstract implements InternetServiceProviderInterface
{
    protected string $operator = 'ooredoo';

    protected int $month = 0;

    protected int $monthlyFees = 150;

    public function setMonth(int $month)
    {
        $this->month = $month;
    }

    public function calculateTotalAmount(): float|int
    {
        return $this->month * $this->monthlyFees;
    }
}