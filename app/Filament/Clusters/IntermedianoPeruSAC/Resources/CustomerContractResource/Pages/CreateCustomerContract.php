<?php

namespace App\Filament\Clusters\IntermedianoPeruSAC\Resources\CustomerContractResource\Pages;

use App\Filament\Clusters\IntermedianoPeruSAC\Resources\CustomerContractResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerContract extends CreateRecord
{
    protected static string $resource = CustomerContractResource::class;
    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }
}
