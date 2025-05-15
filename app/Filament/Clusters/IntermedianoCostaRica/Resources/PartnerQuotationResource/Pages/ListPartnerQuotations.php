<?php

namespace App\Filament\Clusters\IntermedianoCostaRica\Resources\PartnerQuotationResource\Pages;

use App\Filament\Clusters\IntermedianoCostaRica\Resources\PartnerQuotationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPartnerQuotations extends ListRecords
{
    protected static string $resource = PartnerQuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
