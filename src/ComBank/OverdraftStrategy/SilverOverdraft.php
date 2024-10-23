<?php

namespace ComBank\OverdraftStrategy;

use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;

class SilverOverdraft implements OverdraftInterface
{
    private float $overdraftLimit;

    public function __construct(float $limit)
    {
        $this->overdraftLimit = $limit;
    }

    public function isGrantOverdraftFunds(float $amount): bool
    {
        return $amount <= $this->overdraftLimit;
    }

    public function getOverdraftFundsAmount(): float
    {
        return $this->overdraftLimit;
    }
}
