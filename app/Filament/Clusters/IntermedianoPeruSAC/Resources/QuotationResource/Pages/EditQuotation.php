<?php

namespace App\Filament\Clusters\IntermedianoPeruSAC\Resources\QuotationResource\Pages;

use App\Filament\Clusters\IntermedianoPeruSAC\Resources\QuotationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuotation extends EditRecord
{
    protected static string $resource = QuotationResource::class;

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
