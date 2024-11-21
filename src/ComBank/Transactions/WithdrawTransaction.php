<?php
namespace ComBank\Transactions;

use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use ComBank\Support\Traits\ApiTrait;

class WithdrawTransaction extends BaseTransaction implements BankTransactionInterface
{
    use ApiTrait;

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
        // Lógica de fraude: Si el monto a retirar es mayor a un umbral (por ejemplo, 150 €), lo consideramos fraude.
        if ($this->amount > 150) {
            // Lógica de fraude
            throw new \Exception("Fraud detected, transaction blocked.");
        }

        // Si no se detecta fraude, podemos realizar la transacción
        $newBalance = $account->getBalance() - $this->amount;
        
        $account->setBalance($newBalance);
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
