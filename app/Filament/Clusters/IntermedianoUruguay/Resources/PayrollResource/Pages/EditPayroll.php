<?php

namespace App\Filament\Clusters\IntermedianoUruguay\Resources\PayrollResource\Pages;

use App\Filament\Clusters\IntermedianoUruguay\Resources\PayrollResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPayroll extends EditRecord
{
    protected static string $resource = PayrollResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
