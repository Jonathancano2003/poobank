<?php

// Incluir el autoload de Composer
require_once __DIR__ . '/../vendor/autoload.php';

use ComBank\Bank\Person;
use ComBank\Bank\InternationalBankAccount;

$balance = 300;
$person = new Person("Jonathan", "46997013d", "adf@example.com");

// Crear la cuenta internacional con el balance y el titular
$internationalAccount = new InternationalBankAccount($balance, $person);

$conversionRate = 1.10; // Tasa de conversión: 1 USD = 1.10 EUR

// Mostrar información
echo "------- [Start testing international account (Dollar conversion)] -------" . PHP_EOL;
echo "My balance: " . $internationalAccount->getBalance() . " € (Euro)" . PHP_EOL;

// Convertir el balance de euros a dólares
$convertedBalance = $internationalAccount->getConvertedBalance($conversionRate);
echo "Converting balance to Dollars (Rate: 1 USD = " . $conversionRate . " €)" . PHP_EOL;
echo "Converted balance: " . $convertedBalance . " $ (USD)" . PHP_EOL;
