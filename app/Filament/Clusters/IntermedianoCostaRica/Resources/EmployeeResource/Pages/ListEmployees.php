<?php

namespace App\Filament\Clusters\IntermedianoCostaRica\Resources\EmployeeResource\Pages;

use App\Filament\Clusters\IntermedianoCostaRica\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
