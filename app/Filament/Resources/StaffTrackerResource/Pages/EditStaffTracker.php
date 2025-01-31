<?php

namespace App\Filament\Resources\StaffTrackerResource\Pages;

use App\Filament\Resources\StaffTrackerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStaffTracker extends EditRecord
{
    protected static string $resource = StaffTrackerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
