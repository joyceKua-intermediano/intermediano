<?php

namespace App\Filament\Resources\CustomerPortalAccountResource\Pages;

use App\Filament\Resources\CustomerPortalAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerPortalAccounts extends ListRecords
{
    protected static string $resource = CustomerPortalAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
