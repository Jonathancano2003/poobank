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
        $endpoint = 'convert';
        $access_key = '8edb5951059eac35c1a1d280a5c981d9';
        $from = 'EUR';
        $to = 'USD';
        
        $url = 'http://data.fixer.io/api/' . $endpoint . '?access_key=' . $access_key . '&from=' . $from . '&to=' . $to . '&amount=' . $balance;
        
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
            return $response['result'] ?? 0.0;
        } else {
            throw new \Exception('Error en la respuesta de la API: ' . ($response['error']['info'] ?? 'Respuesta inválida'));
        }
    }
    

    public function detectFraud(BankTransactionInterface $transaction): bool
    {
        return false;
    }
}
