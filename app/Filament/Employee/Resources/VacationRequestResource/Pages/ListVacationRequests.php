<?php

namespace App\Filament\Employee\Resources\VacationRequestResource\Pages;

use App\Filament\Employee\Resources\VacationRequestResource;
use App\Filament\Employee\Widgets\EmployeeVacationOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVacationRequests extends ListRecords
{
    protected static string $resource = VacationRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('New Vacation Request'),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            EmployeeVacationOverview::class,
        ];
    }
}
