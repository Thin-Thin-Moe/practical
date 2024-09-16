<?php

namespace App\Services\InternetServiceProvider;

class InternetServiceProviderAbstract
{
    public final function __construct()
    {
        if (!isset($this->operator)) {
            throw new \LogicException(get_class($this).' must have a $operator property.');
        }

        if (!isset($this->month)) {
            throw new \LogicException(get_class($this).' must have a $month property.');
        }

        if (!isset($this->monthlyFees)) {
            throw new \LogicException(get_class($this).' must have a $monthlyFees property.');
        }
    }
}