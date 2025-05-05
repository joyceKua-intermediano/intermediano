<?php

namespace App\Filament\Clusters\IntermedianoPeruSAC\Resources\EmployeeContractResource\Pages;

use App\Filament\Clusters\IntermedianoPeruSAC\Resources\EmployeeContractResource;
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
    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }
}
