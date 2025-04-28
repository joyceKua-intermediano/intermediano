<?php

namespace App\Filament\Clusters\IntermedianoCanada\Resources\PartnerContractResource\Pages;

use App\Filament\Clusters\IntermedianoCanada\Resources\PartnerContractResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPartnerContracts extends ListRecords
{
    protected static string $resource = PartnerContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
