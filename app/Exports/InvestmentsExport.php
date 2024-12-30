<?php

namespace App\Exports;

use App\Models\Investment;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class InvestmentsExport implements FromView
{
    public function view(): View
    {
        $investments = Investment::with(['country', 'bank', 'currency'])->get();
        return view('exports.investments', compact('investments'));
    }
}
