<?php

namespace App\Filament\Clusters\IntermedianoChileSPA\Resources\EmployeeContractResource\Pages;

use App\Filament\Clusters\IntermedianoChileSPA\Resources\EmployeeContractResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployeeContract extends CreateRecord
{
    protected static string $resource = EmployeeContractResource::class;
    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }
}
