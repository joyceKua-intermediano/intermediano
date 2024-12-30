<?php

namespace App\Exports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LeadsExport implements FromView
{
    public function view(): View
    {
        return view('exports.leads', [
            'leads' => Lead::orderByDesc('id')->get()
        ]);
    }
}
