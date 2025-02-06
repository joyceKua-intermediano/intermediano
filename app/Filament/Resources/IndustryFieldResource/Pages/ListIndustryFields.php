<?php

namespace App\Filament\Resources\IndustryFieldResource\Pages;

use App\Filament\Resources\IndustryFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIndustryFields extends ListRecords
{
    protected static string $resource = IndustryFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
