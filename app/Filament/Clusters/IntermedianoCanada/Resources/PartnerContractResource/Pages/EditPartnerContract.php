<?php

namespace App\Filament\Clusters\IntermedianoCanada\Resources\PartnerContractResource\Pages;

use App\Filament\Clusters\IntermedianoCanada\Resources\PartnerContractResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPartnerContract extends EditRecord
{
    protected static string $resource = PartnerContractResource::class;

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
