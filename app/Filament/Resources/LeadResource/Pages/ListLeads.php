<?php

namespace App\Filament\Resources\LeadResource\Pages;

use App\Exports\LeadsExport;
use App\Filament\Resources\LeadResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListLeads extends ListRecords
{
    protected static string $resource = LeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label(__("Lead Registration")),
            Action::make(__("Export pipeline"))->action(function () {
                $file_name = "leads_".date("dmY_His").".xlsx";
                return Excel::download(new LeadsExport, $file_name);
            }),
            Action::make(__("Lead Status Kanban"))
            ->icon('heroicon-o-funnel')
            ->url(route('filament.admin.pages.leads-kanban-board')),
        ];
    }
}
