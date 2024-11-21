<?php

// Incluir el autoload de Composer
require_once __DIR__ . '/../vendor/autoload.php';

use ComBank\Bank\Person;
use ComBank\Bank\InternationalBankAccount;
use ComBank\Transactions\WithdrawTransaction;

// Crear persona y cuenta
$validEmail = "adf@gmail.com";
$personValid = new Person("Jonathan", "46997013d", $validEmail);
$balance = 300;
$internationalAccountValid = new InternationalBankAccount($balance, $personValid);

$conversionRate = 1.10; // Tasa de conversión: 1 USD = 1.10 EUR

// Probar con correo electrónico válido
echo "------- [Start testing international account (Dollar conversion) with valid email] -------" . PHP_EOL;
echo "My balance: " . $internationalAccountValid->getBalance() . " € (Euro)" . PHP_EOL;

// Convertir el balance de euros a dólares
$convertedBalance = $internationalAccountValid->getConvertedBalance($conversionRate);
echo "Converting balance to Dollars (Rate: 1 USD = " . $conversionRate . " €)" . PHP_EOL;
echo "Converted balance: " . $convertedBalance . " $ (USD)" . PHP_EOL;
echo PHP_EOL;

// ------------------ TEST CASE 1: NO FRAUD DETECTED ------------------ 
echo "------- [Start testing Withdraw Transaction with No Fraud Detection] -------" . PHP_EOL;
$withdrawAmount = 100; // Monto para retirar
$withdrawTransaction = new WithdrawTransaction($withdrawAmount);

try {
    $internationalAccountValid->transaction($withdrawTransaction);
    echo "No fraud detected. Transaction allowed." . PHP_EOL;
    echo "Transaction successful. New balance: " . $internationalAccountValid->getBalance() . " €" . PHP_EOL;
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
echo "------- [End testing] -------" . PHP_EOL;
echo PHP_EOL;

// ------------------ TEST CASE 2: FRAUD DETECTED ------------------ 
echo "------- [Start testing Withdraw Transaction with Fraud Detection] -------" . PHP_EOL;
$fraudWithdrawAmount = 200; // Monto para retirar, más alto para simular fraude
$fraudWithdrawTransaction = new WithdrawTransaction($fraudWithdrawAmount);

try {
    $internationalAccountValid->transaction($fraudWithdrawTransaction);
    echo "No fraud detected. Transaction allowed." . PHP_EOL;
    echo "Transaction successful. New balance: " . $internationalAccountValid->getBalance() . " €" . PHP_EOL;
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

echo "------- [End testing] -------" . PHP_EOL;
