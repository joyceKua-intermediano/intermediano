<?php

namespace App\Filament\Clusters\IntermedianoMexicoSC\Resources\EmployeeContractResource\Pages;

use App\Filament\Clusters\IntermedianoMexicoSC\Resources\EmployeeContractResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployeeContract extends CreateRecord
{
    protected static string $resource = EmployeeContractResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
