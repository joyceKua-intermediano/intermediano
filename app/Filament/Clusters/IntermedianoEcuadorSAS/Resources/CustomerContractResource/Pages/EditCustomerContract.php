<?php

namespace App\Filament\Clusters\IntermedianoEcuadorSAS\Resources\CustomerContractResource\Pages;

use App\Filament\Clusters\IntermedianoEcuadorSAS\Resources\CustomerContractResource;
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
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
