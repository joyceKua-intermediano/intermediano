<?php

namespace App\Helpers;

use App\Helpers\ExchangeRateHelper;
use Illuminate\Support\Facades\Session;

class InvestmentHelper
{
    public static function convertToUSDOrDefault($record, callable $calculation): string
    {
        $capital = $record->capital ?? 0;
        $interestRate = 0;
        $timeInMonths = ($record->withdrawal_period ?? 0) / 30;
        $incomeTaxRate = $record->country->income_tax_rate ?? 0;
        $exchangeRate = 1; 

        if ($record->rate_type === 'annual') {
            $annualRate = $record->interest_rate / 100; 
            $interestRate = pow(1 + $annualRate, 1 / 12) - 1;
        } else {
            $interestRate = $record->interest_rate / 100; 
        }

        if ($record->country->use_real_time_conversion) {
            //ExchangeRateHelper::getExchangeRate('USD', $record->currency->currency_name);
            $exchangeRate = $record->currency->converted_currency_quota; 
        } else {
            $exchangeRate = $record->currency->currency_quota ?? 1;
        }

        $value = $calculation($capital, $interestRate, $timeInMonths, $incomeTaxRate);

        $showInUSD = Session::get('show_in_usd', false);

        if ($showInUSD) {
            return 'USD ' . number_format($value / $exchangeRate, 2);
        }

        return $record->currency->currency_name . ' ' . number_format($value, 2);
    }
}
