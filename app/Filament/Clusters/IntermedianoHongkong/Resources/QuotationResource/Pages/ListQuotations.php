<?php

namespace App\Filament\Clusters\IntermedianoHongkong\Resources\QuotationResource\Pages;

use App\Filament\Clusters\IntermedianoHongkong\Resources\QuotationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuotations extends ListRecords
{
    protected static string $resource = QuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
