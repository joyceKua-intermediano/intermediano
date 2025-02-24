<?php

namespace App\Filament\Clusters\IntermedianoChileSPA\Resources\QuotationResource\Pages;

use App\Filament\Clusters\IntermedianoChileSPA\Resources\QuotationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateQuotation extends CreateRecord
{
    protected static string $resource = QuotationResource::class;
    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }
}
