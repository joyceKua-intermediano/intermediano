<?php

namespace App\Filament\Clusters\IntermedianoUruguay\Resources\MspPayrollResource\Pages;

use App\Filament\Clusters\IntermedianoUruguay\Resources\MspPayrollResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMspPayroll extends CreateRecord
{
    protected static string $resource = MspPayrollResource::class;
    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }
}
