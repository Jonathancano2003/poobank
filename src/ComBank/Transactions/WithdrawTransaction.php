<?php

namespace ComBank\Transactions;

use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class WithdrawTransaction extends BaseTransaction implements BankTransactionInterface
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
        // Calculamos el nuevo balance después del retiro
        $newBalance = $account->getBalance() - $this->amount;

        // Verificamos si el balance es negativo y si tiene sobregiro permitido
        if ($newBalance < 0 && !$account->getOverdraft()->isGrantOverdraftFunds($newBalance)) {
            throw new InvalidOverdraftFundsException("Fondos insuficientes para realizar el retiro, incluso con sobregiro.");
        }

        return $newBalance;
    }

    public function getTransactionInfo(): string
    {
        return 'WITHDRAW_TRANSACTION';
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}