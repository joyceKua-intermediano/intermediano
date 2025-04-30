<?php

namespace App\Filament\Clusters\IntermedianoColombiaSAS\Resources\CustomerContractResource\Pages;

use App\Filament\Clusters\IntermedianoColombiaSAS\Resources\CustomerContractResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerContract extends EditRecord
{
    protected static string $resource = CustomerContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }
}
