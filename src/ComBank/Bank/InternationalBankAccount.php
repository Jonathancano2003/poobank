<?php

namespace ComBank\Bank;

class InternationalBankAccount extends BankAccount
{
  

    public function getConvertedBalance(float $exchangeRate): float
    {
    }

    public function getConvertedCurrency(string $newCurrency): string
    {
    }
}