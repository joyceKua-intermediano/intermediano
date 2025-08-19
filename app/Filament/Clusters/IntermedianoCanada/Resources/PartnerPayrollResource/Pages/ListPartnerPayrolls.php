<?php

namespace App\Filament\Clusters\IntermedianoCanada\Resources\PartnerPayrollResource\Pages;

use App\Filament\Clusters\IntermedianoCanada\Resources\PartnerPayrollResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

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
