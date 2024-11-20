<?php

namespace ComBank\Support\Traits;

use ComBank\Transactions\Contracts\BankTransactionInterface;

trait ApiTrait
{
    public function validateEmail(string $email): bool
    {
        $access_key="92928b756e623357b3bd80e8dc90deae35725659144d0a8b8389e58ff8c0d62a7768898ce6505cc541c4e21d45071dcf";
        $url = 'https://verifyright.co/verify/' . $email . '?token=' . $access_key;
        $status=false;

        $ch=curl_init($url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $json = curl_exec($ch);
        
        if (curl_errno($ch)) {
            curl_close($ch);
            throw new \Exception('Error al conectar con la API: ' . curl_error($ch));
        }
        curl_close($ch);
        $response=json_decode($json,true);
        if(isset($response['status'])&& $response['status']==true){
            $status=true;
        }
        return $status;

    }

    public function convertBalance(float $balance): float
    {
        $access_key = '8edb5951059eac35c1a1d280a5c981d9';
        $url = 'http://data.fixer.io/api/latest?access_key=' . $access_key . '&symbols=USD';
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, value: true);
        
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
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://673cd09496b8dcd5f3fbcb5b.mockapi.io/fraud");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            if(curl_errno($ch)) {
                throw new \Exception('cURL Error: ' . curl_error($ch));
            }
            curl_close($ch);
            $fraudRules = json_decode($response, true);
            $movement = $transaction->getTransactionInfo();
            $amount = $transaction->getAmount();
            foreach ($fraudRules as $rule) {
                if ($rule['movement'] === $movement) {
                    if ($amount >= $rule['amount_range']['min'] && $amount <= $rule['amount_range']['max']) {
                        if ($rule['risk'] >= 75) {
                            return true;
                        }
                        return false;
                    }
                }
            }
            return false;
        } catch (\Exception $e) {
            return true;
        }
    }
    
}
