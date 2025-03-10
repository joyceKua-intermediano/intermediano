<?php

namespace App\Filament\Employee\Resources\PersonalInformationResource\Pages;

use App\Filament\Employee\Resources\PersonalInformationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePersonalInformation extends CreateRecord
{
    protected static string $resource = PersonalInformationResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
