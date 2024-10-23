<?php

namespace ComBank\Support\Traits;

use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;

trait AmountValidationTrait
{
    public function validateAmount(float $amount): void
    {
        if ($amount < 0) {
            throw new InvalidArgsException("Amount cannot be negative.");
        }
    }
}
