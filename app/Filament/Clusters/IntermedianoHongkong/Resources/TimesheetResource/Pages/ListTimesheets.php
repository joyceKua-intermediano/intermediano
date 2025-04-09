<?php

namespace App\Filament\Clusters\IntermedianoHongkong\Resources\TimesheetResource\Pages;

use App\Filament\Clusters\IntermedianoHongkong\Resources\TimesheetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTimesheets extends ListRecords
{
    protected static string $resource = TimesheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
