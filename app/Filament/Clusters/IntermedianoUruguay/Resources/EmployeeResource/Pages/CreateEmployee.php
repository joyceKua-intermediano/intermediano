<?php

namespace App\Filament\Clusters\IntermedianoUruguay\Resources\EmployeeResource\Pages;

use App\Filament\Clusters\IntermedianoUruguay\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;
    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }
}
