<?php

namespace App\Filament\Clusters\IntermedianoCostaRica\Resources\PartnerContractResource\Pages;

use App\Filament\Clusters\IntermedianoCostaRica\Resources\PartnerContractResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPartnerContract extends EditRecord
{
    protected static string $resource = PartnerContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
