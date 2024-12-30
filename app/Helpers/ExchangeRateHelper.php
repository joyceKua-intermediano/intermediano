<?php

namespace App\Helpers;

use Exception;

class ExchangeRateHelper
{
    public static function getExchangeRate(string $baseCurrency, string $targetCurrency): float|string
    {        
        $url = "https://hexarate.paikama.co/api/rates/latest/$baseCurrency?target=$targetCurrency";

        try {
            $response = file_get_contents($url);
            $data = json_decode($response, true);
            if (isset($data['data']['mid'])) {
                return $data['data']['mid'];
            }

            return 'Error: Conversion rate not available.';
        } catch (Exception $e) {
            return 'Error: Unable to fetch rates.';
        }
    }
}
