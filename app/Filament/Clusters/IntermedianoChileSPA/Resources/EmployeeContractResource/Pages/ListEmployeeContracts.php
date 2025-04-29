<?php

namespace App\Filament\Clusters\IntermedianoChileSPA\Resources\EmployeeContractResource\Pages;

use App\Filament\Clusters\IntermedianoChileSPA\Resources\EmployeeContractResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeContracts extends ListRecords
{
    protected static string $resource = EmployeeContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
