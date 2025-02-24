<?php

namespace App\Filament\Clusters\IntermedianoColombiaSAS\Resources\PayrollResource\Pages;

use App\Filament\Clusters\IntermedianoColombiaSAS\Resources\PayrollResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePayroll extends CreateRecord
{
    protected static string $resource = PayrollResource::class;
    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }
}
