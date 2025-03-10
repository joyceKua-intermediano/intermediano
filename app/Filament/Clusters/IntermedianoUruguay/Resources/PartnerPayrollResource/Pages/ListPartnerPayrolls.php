<?php

namespace App\Filament\Clusters\IntermedianoUruguay\Resources\PartnerPayrollResource\Pages;

use App\Filament\Clusters\IntermedianoUruguay\Resources\PartnerPayrollResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListPartnerPayrolls extends ListRecords
{
    protected static string $resource = PartnerPayrollResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

        ];
    }
}
