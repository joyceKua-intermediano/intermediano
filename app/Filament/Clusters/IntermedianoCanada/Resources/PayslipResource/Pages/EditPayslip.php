<?php

namespace App\Filament\Clusters\IntermedianoCanada\Resources\PayslipResource\Pages;

use App\Filament\Clusters\IntermedianoCanada\Resources\PayslipResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPayslip extends EditRecord
{
    protected static string $resource = PayslipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
