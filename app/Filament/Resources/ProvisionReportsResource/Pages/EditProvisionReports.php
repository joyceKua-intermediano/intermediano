<?php

namespace App\Filament\Resources\ProvisionReportsResource\Pages;

use App\Filament\Resources\ProvisionReportsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProvisionReports extends EditRecord
{
    protected static string $resource = ProvisionReportsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
