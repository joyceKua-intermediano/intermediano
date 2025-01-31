<?php

namespace App\Filament\Resources\StaffTrackerResource\Pages;

use App\Filament\Resources\StaffTrackerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStaffTrackers extends ListRecords
{
    protected static string $resource = StaffTrackerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
