<?php

namespace App\Filament\Resources\CountryAnnualSetupResource\Pages;

use App\Filament\Resources\CountryAnnualSetupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCountryAnnualSetups extends ListRecords
{
    protected static string $resource = CountryAnnualSetupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
