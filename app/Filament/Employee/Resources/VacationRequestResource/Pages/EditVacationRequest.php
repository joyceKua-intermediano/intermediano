<?php

namespace App\Filament\Employee\Resources\VacationRequestResource\Pages;

use App\Filament\Employee\Resources\VacationRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVacationRequest extends EditRecord
{
    protected static string $resource = VacationRequestResource::class;

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
