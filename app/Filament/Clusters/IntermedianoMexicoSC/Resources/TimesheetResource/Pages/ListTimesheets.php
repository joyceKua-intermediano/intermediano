<?php

namespace App\Filament\Clusters\IntermedianoMexicoSC\Resources\TimesheetResource\Pages;

use App\Filament\Clusters\IntermedianoMexicoSC\Resources\TimesheetResource;
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
