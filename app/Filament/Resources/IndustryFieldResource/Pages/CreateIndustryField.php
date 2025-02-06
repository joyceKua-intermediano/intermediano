<?php

namespace App\Filament\Resources\IndustryFieldResource\Pages;

use App\Filament\Resources\IndustryFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIndustryField extends CreateRecord
{
    protected static string $resource = IndustryFieldResource::class;
    
    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }
}
