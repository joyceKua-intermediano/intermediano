<?php

namespace App\Filament\Clusters\IntermedianoHongkong\Resources\PartnerQuotationResource\Pages;

use App\Filament\Clusters\IntermedianoHongkong\Resources\PartnerQuotationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePartnerQuotation extends CreateRecord
{
    protected static string $resource = PartnerQuotationResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
