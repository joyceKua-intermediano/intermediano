<?php

namespace App\Filament\Employee\Resources\VacationRequestResource\Pages;

use App\Filament\Employee\Resources\VacationRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateVacationRequest extends CreateRecord
{
    protected static string $resource = VacationRequestResource::class;
    public function getTitle(): string | Htmlable
    {
        return 'Vacation Request';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
