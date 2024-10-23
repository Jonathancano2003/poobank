<?php

namespace ComBank\OverdraftStrategy;

use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;

class NoOverdraft implements OverdraftInterface
{
    public function isGrantOverdraftFunds(float $balance): bool
    {
        // No se permite sobregiro, por lo tanto, siempre devolverá false si el balance es negativo
        return $balance >= 0;
    }

    public function getOverdraftFundsAmount(): float
    {
        return 0.0;
    }
}
