<?php

namespace App\Filament\Resources\CountryAnnualSetupResource\Pages;

use App\Filament\Resources\CountryAnnualSetupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCountryAnnualSetup extends EditRecord
{
    protected static string $resource = CountryAnnualSetupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
