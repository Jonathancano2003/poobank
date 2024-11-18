<?php

namespace ComBank\Support\Traits;

use ComBank\Transactions\Contracts\BankTransactionInterface;

trait ApiTrait
{
    public function validateEmail(string $email): bool
    {
        return false;
    }

    public function convertBalance(float $balance): float
    {
        $access_key = '8edb5951059eac35c1a1d280a5c981d9';
        $url = 'http://data.fixer.io/api/latest?access_key=' . $access_key . '&symbols=USD';
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $json = curl_exec($ch);
        
        if (curl_errno($ch)) {
            curl_close($ch);
            throw new \Exception('Error al conectar con la API: ' . curl_error($ch));
        }
        
        curl_close($ch);
        
        $response = json_decode($json, true);
        
        if (isset($response['success']) && $response['success'] === true) {
            $rate = $response['rates']['USD'] ?? null;
            if ($rate !== null) {
                return $balance * $rate;
            } else {
                throw new \Exception('No se encontró la tasa de cambio para USD');
            }
        } else {
            throw new \Exception('Error en la respuesta de la API: ' . ($response['error']['info'] ?? 'Respuesta inválida'));
        }
    }
    
    

    public function detectFraud(BankTransactionInterface $transaction): bool
    {
        return false;
    }
}
