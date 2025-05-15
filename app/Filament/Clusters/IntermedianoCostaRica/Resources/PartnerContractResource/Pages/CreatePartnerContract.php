<?php

namespace App\Filament\Clusters\IntermedianoCostaRica\Resources\PartnerContractResource\Pages;

use App\Filament\Clusters\IntermedianoCostaRica\Resources\PartnerContractResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePartnerContract extends CreateRecord
{
    protected static string $resource = PartnerContractResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
