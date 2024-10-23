<?php

namespace ComBank\OverdraftStrategy;

use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;

class NoOverdraft implements OverdraftInterface
{
    public function isGrantOverdraftFunds(float $amount): bool
    {
        return false;
    }

    public function getOverdraftFundsAmount(): float
    {
        return 0.0;
    }
}
