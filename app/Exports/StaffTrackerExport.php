<?php

namespace App\Exports;

use App\Models\StaffTracker;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class StaffTrackerExport implements FromView
{
    public function view(): View
    {
        $staffs = StaffTracker::with(
            [
                'consultant',
                'country',
                'industry_field',
                'company',
                'intermedianoCompany',
                'partner'
            ]
        )->get();

        return view('exports.staff_trackers', compact('staffs'));
    }
}
