<?php

namespace App\Filament\Employee\Resources\EmployeeContractResource\Pages;

use App\Filament\Employee\Resources\EmployeeContractResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeContract extends EditRecord
{
    protected static string $resource = EmployeeContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
