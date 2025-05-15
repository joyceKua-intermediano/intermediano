<?php

namespace App\Filament\Clusters\IntermedianoCostaRica\Resources\PartnerContractResource\Pages;

use App\Filament\Clusters\IntermedianoCostaRica\Resources\PartnerContractResource;
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
