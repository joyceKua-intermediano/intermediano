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

        return view('exports.countries', compact('countries'));
    }
}
