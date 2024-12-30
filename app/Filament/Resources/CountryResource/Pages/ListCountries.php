<?php

namespace App\Filament\Resources\CountryResource\Pages;

use App\Exports\CountriesExport;
use App\Filament\Resources\CountryResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListCountries extends ListRecords
{
    protected static string $resource = CountryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add new country'),
            Action::make(__("Export countries"))->action(function () {
                $file_name = "countries_".date("dmY_His").".xlsx";
                return Excel::download(new CountriesExport, $file_name);
            }),
        ];
    }
}
