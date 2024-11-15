<?php

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:24 PM
 */

use ComBank\Bank\BankAccount;
use ComBank\OverdraftStrategy\SilverOverdraft;
use ComBank\Transactions\DepositTransaction;
use ComBank\Transactions\WithdrawTransaction;
use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\ZeroAmountException;

require_once 'bootstrap.php';

//---[Bank account 1]---/
// create a new account1 with balance 400
pl('--------- [Start testing bank account #1, No overdraft] --------');
try {
 
    $bankAccount1 = new BankAccount(400);

   
    pl('Doing transaction deposit (+150) with current balance ' . $bankAccount1->getBalance());
    $deposit = new DepositTransaction(150);
    $bankAccount1->transaction($deposit);  
    pl('My new balance after deposit (+150): ' . $bankAccount1->getBalance());

  
    pl('Doing transaction withdrawal (-25) with current balance ' . $bankAccount1->getBalance());
    $withdrawal = new WithdrawTransaction(25);
    $bankAccount1->transaction($withdrawal);  
    pl('My new balance after withdrawal (-25): ' . $bankAccount1->getBalance());


    pl('Doing transaction withdrawal (-600) with current balance ' . $bankAccount1->getBalance());
    $withdrawalBig = new WithdrawTransaction(600);
    $bankAccount1->transaction($withdrawalBig);  
} catch (ZeroAmountException $e) {
    pl($e->getMessage());
} catch (BankAccountException $e) {
    pl($e->getMessage());
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My balance after failed last transaction: ' . $bankAccount1->getBalance());

//---[Bank account 2]---/

pl('--------- [Start testing bank account #2, Silver overdraft (100.0 funds)] --------');
try {
    $bankAccount2 = new BankAccount(400);
    $bankAccount2->applyOverdraft(new SilverOverdraft(100.0));  

    
    pl('Doing transaction deposit (+100) with current balance ' . $bankAccount2->getBalance());
    $deposit = new DepositTransaction(100);
    $bankAccount2->transaction($deposit);
    pl('My new balance after deposit (+100): ' . $bankAccount2->getBalance());

  
    pl('Doing transaction withdrawal (-300) with current balance ' . $bankAccount2->getBalance());
    $withdrawal = new WithdrawTransaction(300);
    $bankAccount2->transaction($withdrawal);
    pl('My new balance after withdrawal (-300): ' . $bankAccount2->getBalance());

    
    pl('Doing transaction withdrawal (-50) with current balance ' . $bankAccount2->getBalance());
    $withdrawal = new WithdrawTransaction(50);
    $bankAccount2->transaction($withdrawal);
    pl('My new balance after withdrawal (-50) with funds: ' . $bankAccount2->getBalance());

    
    pl('Doing transaction withdrawal (-120) with current balance ' . $bankAccount2->getBalance());
    $withdrawalBig = new WithdrawTransaction(120);
    $bankAccount2->transaction($withdrawalBig);
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My balance after failed last transaction: ' . $bankAccount2->getBalance());
