<?php

namespace App\Filament\Clusters\IntermedianoHongkong\Resources\PartnerContractResource\Pages;

use App\Filament\Clusters\IntermedianoHongkong\Resources\PartnerContractResource;
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
