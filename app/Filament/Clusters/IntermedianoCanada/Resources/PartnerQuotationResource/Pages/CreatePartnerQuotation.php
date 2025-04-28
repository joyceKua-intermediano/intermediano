<?php

namespace App\Filament\Clusters\IntermedianoCanada\Resources\PartnerQuotationResource\Pages;

use App\Filament\Clusters\IntermedianoCanada\Resources\PartnerQuotationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePartnerQuotation extends CreateRecord
{
    protected static string $resource = PartnerQuotationResource::class;
    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }
}
