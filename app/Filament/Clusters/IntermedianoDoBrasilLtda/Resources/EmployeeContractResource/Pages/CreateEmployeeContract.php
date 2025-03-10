<?php

namespace App\Filament\Clusters\IntermedianoDoBrasilLtda\Resources\EmployeeContractResource\Pages;

use App\Filament\Clusters\IntermedianoDoBrasilLtda\Resources\EmployeeContractResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployeeContract extends CreateRecord
{
    protected static string $resource = EmployeeContractResource::class;
    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }
}
