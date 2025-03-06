<?php

namespace App\Filament\Clusters\IntermedianoUruguay\Resources\MspPayrollResource\Pages;

use App\Filament\Clusters\IntermedianoUruguay\Resources\MspPayrollResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMspPayrolls extends ListRecords
{
    protected static string $resource = MspPayrollResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
