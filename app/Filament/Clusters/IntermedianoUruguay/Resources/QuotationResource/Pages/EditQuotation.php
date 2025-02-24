<?php

namespace App\Filament\Clusters\IntermedianoUruguay\Resources\QuotationResource\Pages;

use App\Filament\Clusters\IntermedianoUruguay\Resources\QuotationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuotation extends EditRecord
{
    protected static string $resource = QuotationResource::class;

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
