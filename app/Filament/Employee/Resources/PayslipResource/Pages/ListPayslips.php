<?php

namespace App\Filament\Employee\Resources\PayslipResource\Pages;

use App\Filament\Employee\Resources\PayslipResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPayslips extends ListRecords
{
    protected static string $resource = PayslipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
