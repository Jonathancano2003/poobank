<?php

namespace ComBank\Transactions;

use ComBank\Exceptions\ZeroAmountException;
use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class DepositTransaction extends BaseTransaction implements BankTransactionInterface
{
    public function __construct(float $amount)
    {
        // Validación del monto al asignar el valor
        if ($amount <= 0) {
            throw new ZeroAmountException("El monto de la transacción no puede ser cero o negativo.");
        }

        // Asignamos el monto solo si es válido
        $this->amount = $amount;
    }

    public function applyTransaction(BankAccountInterface $account): float
    {
        // Aumentamos el balance con el monto del depósito
        $newBalance = $account->getBalance() + $this->amount;
        return $newBalance;
    }

    public function getTransactionInfo(): string
    {
        return 'DEPOSIT_TRANSACTION';
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}