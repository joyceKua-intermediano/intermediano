<?php

namespace App\Filament\Clusters\IntermedianoEcuadorSAS\Resources\EmployeeContractResource\Pages;

use App\Filament\Clusters\IntermedianoEcuadorSAS\Resources\EmployeeContractResource;
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
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
