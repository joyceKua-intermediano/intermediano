<?php

namespace App\Filament\Resources\IntermedianoCompanyResource\Pages;

use App\Filament\Resources\IntermedianoCompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIntermedianoCompany extends EditRecord
{
    protected static string $resource = IntermedianoCompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
