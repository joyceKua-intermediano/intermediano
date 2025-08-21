<?php

namespace App\Filament\Clusters\IntermedianoHongkong\Resources\PartnerPayrollResource\Pages;

use App\Filament\Clusters\IntermedianoHongkong\Resources\PartnerPayrollResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePartnerPayroll extends CreateRecord
{
    protected static string $resource = PartnerPayrollResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
