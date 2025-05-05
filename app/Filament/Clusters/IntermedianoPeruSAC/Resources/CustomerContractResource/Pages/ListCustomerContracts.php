<?php

namespace App\Filament\Clusters\IntermedianoPeruSAC\Resources\CustomerContractResource\Pages;

use App\Filament\Clusters\IntermedianoPeruSAC\Resources\CustomerContractResource;
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
