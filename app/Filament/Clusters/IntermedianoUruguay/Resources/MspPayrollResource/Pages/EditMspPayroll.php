<?php

namespace App\Filament\Clusters\IntermedianoUruguay\Resources\MspPayrollResource\Pages;

use App\Filament\Clusters\IntermedianoUruguay\Resources\MspPayrollResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMspPayroll extends EditRecord
{
    protected static string $resource = MspPayrollResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }
}
