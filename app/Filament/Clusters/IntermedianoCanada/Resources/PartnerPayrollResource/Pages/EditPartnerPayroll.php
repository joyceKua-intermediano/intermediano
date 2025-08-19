<?php

namespace App\Filament\Clusters\IntermedianoCanada\Resources\PartnerPayrollResource\Pages;

use App\Filament\Clusters\IntermedianoCanada\Resources\PartnerPayrollResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPartnerPayroll extends EditRecord
{
    protected static string $resource = PartnerPayrollResource::class;

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
