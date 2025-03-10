<?php

namespace App\Filament\Customer\Resources\VacationRequestResource\Pages;

use App\Filament\Customer\Resources\VacationRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVacationRequest extends CreateRecord
{
    protected static string $resource = VacationRequestResource::class;
}
