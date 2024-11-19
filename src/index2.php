<?php

// Incluir el autoload de Composer
require_once __DIR__ . '/../vendor/autoload.php';

use ComBank\Bank\Person;
use ComBank\Bank\InternationalBankAccount;

$balance = 300;

// Probar con un correo válido
$validEmail = "adf@gmail.com";
$personValid = new Person("Jonathan", "46997013d", $validEmail);

// Crear la cuenta internacional con el balance y el titular
$internationalAccountValid = new InternationalBankAccount($balance, $personValid);

$conversionRate = 1.10; // Tasa de conversión: 1 USD = 1.10 EUR

// Mostrar información
echo "------- [Start testing international account (Dollar conversion) with valid email] -------" . PHP_EOL;
echo "My balance: " . $internationalAccountValid->getBalance() . " € (Euro)" . PHP_EOL;

// Convertir el balance de euros a dólares
$convertedBalanceValid = $internationalAccountValid->getConvertedBalance($conversionRate);
echo "Converting balance to Dollars (Rate: 1 USD = " . $conversionRate . " €)" . PHP_EOL;
echo "Converted balance: " . $convertedBalanceValid . " $ (USD)" . PHP_EOL;
echo PHP_EOL;

// Probar con un correo inválido
$invalidEmail = "invalid-email";
$personInvalid = new Person("Jonathan", "46997013d", $invalidEmail);

// Crear la cuenta internacional con el balance y el titular
$internationalAccountInvalid = new InternationalBankAccount($balance, $personInvalid);

echo "------- [Start testing international account (Dollar conversion) with invalid email] -------" . PHP_EOL;
echo "My balance: " . $internationalAccountInvalid->getBalance() . " € (Euro)" . PHP_EOL;

// Convertir el balance de euros a dólares
$convertedBalanceInvalid = $internationalAccountInvalid->getConvertedBalance($conversionRate);
echo "Converting balance to Dollars (Rate: 1 USD = " . $conversionRate . " €)" . PHP_EOL;
echo "Converted balance: " . $convertedBalanceInvalid . " $ (USD)" . PHP_EOL;


