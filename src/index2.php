<?php

// Incluir el autoload de Composer
require_once __DIR__ . '/../vendor/autoload.php';

use ComBank\Bank\Person;
use ComBank\Bank\InternationalBankAccount;
use ComBank\Transactions\WithdrawTransaction;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Bank\Contracts\BankAccountInterface;

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

// Probar la transacción de retiro y la detección de fraude
echo "------- [Start testing Withdraw Transaction] -------" . PHP_EOL;

try {
    // Crear una instancia de la cuenta bancaria (puedes usar un mock o una implementación real de BankAccountInterface)
    $account = $internationalAccountValid;  // Usamos la cuenta internacional válida como ejemplo

    // Establecer el monto de la transacción
    $amount = 1500;
    $withdrawTransaction = new WithdrawTransaction($amount);  // Monto de la transacción

    // Intentar aplicar la transacción (esto va a verificar si hay fraude)
    $newBalance = $withdrawTransaction->applyTransaction($account);

    // Si todo es correcto, imprimir el nuevo balance
    echo "Transacción exitosa. El nuevo balance es: " . $newBalance . " € (Euro)" . PHP_EOL;
} catch (ZeroAmountException $e) {
    // Manejar errores específicos como cuando el monto es cero o negativo
    echo "Error: " . $e->getMessage() . "\n";
} catch (InvalidOverdraftFundsException $e) {
    // Manejar otros errores como los problemas con el sobregiro
    echo "Error: " . $e->getMessage() . "\n";
} catch (\Exception $e) {
    // Manejar cualquier otro tipo de excepción, como la de fraude
    echo "Error: " . $e->getMessage() . "\n";
}

?>
