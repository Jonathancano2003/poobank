<?php

namespace ComBank\Bank;

use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\OverdraftStrategy\NoOverdraft;
use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
use ComBank\Support\Traits\AmountValidationTrait;
use ComBank\Support\Traits\ApiTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class BankAccount implements BankAccountInterface
{
    use AmountValidationTrait;
    use ApiTrait;
    private float $balance;
    private bool $status;
    private OverdraftInterface $overdraft;

    const STATUS_OPEN = true;
    const STATUS_CLOSED = false;

    public function __construct($balance)
    {
        $this->setBalance($balance);
        $this->status = self::STATUS_OPEN;
        $this->overdraft = new NoOverdraft();
    }

    public function transaction(BankTransactionInterface $transaction): void
    {
        if (!$this->isOpen()) {
            throw new BankAccountException("La cuenta está cerrada, no se pueden realizar transacciones.");
        }

        try {
            $newBalance = $transaction->applyTransaction($this);
            $this->setBalance($newBalance);
        } catch (InvalidOverdraftFundsException $e) {
            throw new FailedTransactionException("Transacción fallida: " . $e->getMessage());
        }
    }

    public function isOpen(): bool
    {
        return $this->status === self::STATUS_OPEN;
    }

    public function reopenAccount(): void
    {
        if ($this->status === self::STATUS_OPEN) {
            throw new BankAccountException("La cuenta ya está abierta y no se puede reabrir.");
        }
        $this->status = self::STATUS_OPEN;
    }

    public function closeAccount(): void
    {
        if ($this->status !== self::STATUS_CLOSED) {
            $this->status = self::STATUS_CLOSED;
        }
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function getOverdraft(): OverdraftInterface
    {
        return $this->overdraft;
    }

    public function applyOverdraft(OverdraftInterface $overdraft): void
    {
      
        $this->overdraft = $overdraft;
    }

    public function setBalance(float $balance): void
    {
       
        if ($balance < 0 && !$this->overdraft->isGrantOverdraftFunds($balance)) {
            throw new InvalidOverdraftFundsException("Fondos de sobregiro insuficientes para cubrir el balance negativo.");
        }

        $this->balance = $balance;
    }
}
