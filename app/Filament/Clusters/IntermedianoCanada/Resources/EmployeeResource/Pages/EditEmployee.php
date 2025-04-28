<?php

namespace App\Filament\Clusters\IntermedianoCanada\Resources\EmployeeResource\Pages;

use App\Filament\Clusters\IntermedianoCanada\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;

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
