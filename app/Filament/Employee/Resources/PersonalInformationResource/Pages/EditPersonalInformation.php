<?php

namespace App\Filament\Employee\Resources\PersonalInformationResource\Pages;

use App\Filament\Employee\Resources\PersonalInformationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPersonalInformation extends EditRecord
{
    protected static string $resource = PersonalInformationResource::class;

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
