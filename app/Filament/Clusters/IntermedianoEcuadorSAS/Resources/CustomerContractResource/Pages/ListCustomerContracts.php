<?php

namespace App\Filament\Clusters\IntermedianoEcuadorSAS\Resources\CustomerContractResource\Pages;

use App\Filament\Clusters\IntermedianoEcuadorSAS\Resources\CustomerContractResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerContracts extends ListRecords
{
    protected static string $resource = CustomerContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
