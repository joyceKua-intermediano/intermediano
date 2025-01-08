<?php

use App\Helpers\ExchangeRateHelper;
use App\Models\Country;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::call(function () {
    $countries = Country::with('currencies')->get();

    foreach ($countries as $country) {
        $currencies = $country->currencies;

        $convertedCurrencies = [];
        foreach($currencies as $currency) {
            Log::info("Processing currency {$currency->currency_name}");
                $rate = ExchangeRateHelper::getExchangeRate('USD', $currency->currency_name);
                $convertedCurrencies[] = $rate;
        }
        if (is_numeric($rate)) {
            DB::table('countries')
                ->where('id', $country->id)
                ->update(['converted_currency_quota' => json_encode($convertedCurrencies), 'updated_at' => now()]);
        } else {
            Log::error("Failed to fetch exchange rate for {$country->name}: $rate");
        }

    }
})->everySecond();
