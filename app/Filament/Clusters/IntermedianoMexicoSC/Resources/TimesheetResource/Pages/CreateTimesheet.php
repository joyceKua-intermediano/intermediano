<?php

namespace App\Filament\Clusters\IntermedianoMexicoSC\Resources\TimesheetResource\Pages;

use App\Filament\Clusters\IntermedianoMexicoSC\Resources\TimesheetResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTimesheet extends CreateRecord
{
    protected static string $resource = TimesheetResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
