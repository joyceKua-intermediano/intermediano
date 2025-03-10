<?php

namespace App\Filament\Resources\CustomerPortalAccountResource\Pages;

use App\Filament\Resources\CustomerPortalAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerPortalAccount extends EditRecord
{
    protected static string $resource = CustomerPortalAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
