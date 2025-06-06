<?php

namespace App\Filament\Clusters\IntermedianoMexicoSC\Resources\TimesheetResource\Pages;

use App\Filament\Clusters\IntermedianoMexicoSC\Resources\TimesheetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTimesheet extends EditRecord
{
    protected static string $resource = TimesheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
