<?php

namespace App\Filament\Clusters\IntermedianoCanada\Resources\PartnerContractResource\Pages;

use App\Filament\Clusters\IntermedianoCanada\Resources\PartnerContractResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePartnerContract extends CreateRecord
{
    protected static string $resource = PartnerContractResource::class;
    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }
}
