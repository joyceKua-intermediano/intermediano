<?php

namespace App\Filament\Clusters\IntermedianoUruguay\Resources\CustomerContractResource\Pages;

use App\Filament\Clusters\IntermedianoUruguay\Resources\CustomerContractResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerContract extends EditRecord
{
    protected static string $resource = CustomerContractResource::class;

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
