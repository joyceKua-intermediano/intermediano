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

    public static function getExchangeRateForInvestment($investment): float | string {
        if ($investment->country->use_real_time_conversion) {
            if($investment->currency->converted_currency_quota < 1) {
               return $investment->currency->currency_quota;
            }
            return $investment->currency->converted_currency_quota;
        } else {
            return $investment->currency->currency_quota ?? 1;
        }

    }
}
