<?php

namespace ComBank\OverdraftStrategy;

use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;

class SilverOverdraft implements OverdraftInterface
{


    

    public function isGrantOverdraftFunds($float): bool
    {
        // Permitir sobregiro si el balance resultante no excede el límite de sobregiro
      return $float + $this->getOverdraftFundsAmount()>=0;
    }

    public function getOverdraftFundsAmount(): float
    {
        return 100.0;
    }
}
