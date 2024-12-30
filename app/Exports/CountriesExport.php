<?php

namespace App\Exports;

use App\Models\Country;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class CountriesExport implements FromView
{
    public function view(): View
    {
        $countries = Country::with(['currencies', 'banks'])->get();
       foreach ($countries as $country) {
        $firstCurrency = $country->currencies->first();

        $country->exchange_rate = $country->use_real_time_conversion
            ? \App\Helpers\ExchangeRateHelper::getExchangeRate('USD', $firstCurrency?->currency_name)
            : $firstCurrency?->currency_quota ?? $firstCurrency?->currency_name;
    }

        return view('exports.countries', compact('countries'));
    }
}
