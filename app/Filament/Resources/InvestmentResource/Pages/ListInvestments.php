<?php

namespace App\Filament\Resources\InvestmentResource\Pages;

use App\Exports\InvestmentsExport;
use App\Filament\Resources\InvestmentResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListInvestments extends ListRecords
{
    protected static string $resource = InvestmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make(__("Export investments"))->action(function () {
                $file_name = "investments_".date("dmY_His").".xlsx";
                return Excel::download(new InvestmentsExport, $file_name);
            }),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Resources\InvestmentResource\Widgets\InvestmentWidget::class,
        ];
    }
}
