<?php

namespace App\Filament\Resources\StaffTrackerResource\Pages;

use App\Exports\StaffTrackerExport;
use App\Filament\Resources\StaffTrackerResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListStaffTrackers extends ListRecords
{
    protected static string $resource = StaffTrackerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make(__("Export Staff Tracker"))->action(function () {
                $file_name = "staff_tracker_".date("dmY_His").".xlsx";
                return Excel::download(new StaffTrackerExport, $file_name);
            }),
        ];
    }
}
