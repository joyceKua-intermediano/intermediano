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
    // Fetch all countries where real-time conversion is enabled
    $countries = Country::with('currencies')->get();

    
    // Log::info("Processing country {$countries}");

    foreach ($countries as $country) {
        $currency = $country->currencies->first(); // Assuming a country has one currency
        Log::info("Processing currency {$currency->currency_name}");

        // Get the exchange rate
        $rate = ExchangeRateHelper::getExchangeRate('USD', $currency->currency_name);
        if (is_numeric($rate)) {
            // Update the `converted_currency_real` field
            DB::table('countries')
                ->where('id', $country->id)
                ->update(['converted_currency_quota' =>$rate, 'updated_at' => now()]);
        } else {
            // Log the error if the rate cannot be fetched
            Log::error("Failed to fetch exchange rate for {$country->name}: $rate");
        }
    }
})->everySecond();
