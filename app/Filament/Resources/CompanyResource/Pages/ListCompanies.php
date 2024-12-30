<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Exports\CompaniesExport;
use App\Exports\ContactsExport;
use App\Filament\Resources\CompanyResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListCompanies extends ListRecords
{
    protected static string $resource = CompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label(__("Company Registration")),
            Action::make(__("Export companies"))->action(function () {
                $file_name = "companies_".date("dmY_His").".xlsx";
                return Excel::download(new CompaniesExport, $file_name);
            }),
            Action::make(__("Export contacts"))->action(function () {
                $file_name = "contacts_".date("dmY_His").".xlsx";
                return Excel::download(new ContactsExport, $file_name);
            })
        ];
    }
}
