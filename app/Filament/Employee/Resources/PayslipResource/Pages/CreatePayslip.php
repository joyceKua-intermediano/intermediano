<?php

namespace App\Filament\Employee\Resources\PayslipResource\Pages;

use App\Filament\Employee\Resources\PayslipResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePayslip extends CreateRecord
{
    protected static string $resource = PayslipResource::class;
}
