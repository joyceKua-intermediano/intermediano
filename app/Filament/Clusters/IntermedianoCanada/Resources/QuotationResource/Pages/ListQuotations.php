<?php

namespace App\Filament\Clusters\IntermedianoCanada\Resources\QuotationResource\Pages;

use App\Filament\Clusters\IntermedianoCanada\Resources\QuotationResource;
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
