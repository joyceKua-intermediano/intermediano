<?php

namespace App\Filament\Clusters\IntermedianoCanada\Resources\PartnerQuotationResource\Pages;

use App\Filament\Clusters\IntermedianoCanada\Resources\PartnerQuotationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPartnerQuotation extends EditRecord
{
    protected static string $resource = PartnerQuotationResource::class;

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
