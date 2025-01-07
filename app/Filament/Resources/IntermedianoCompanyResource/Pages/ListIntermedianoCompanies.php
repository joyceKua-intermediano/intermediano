<?php

namespace App\Filament\Resources\IntermedianoCompanyResource\Pages;

use App\Filament\Resources\IntermedianoCompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIntermedianoCompanies extends ListRecords
{
    protected static string $resource = IntermedianoCompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
