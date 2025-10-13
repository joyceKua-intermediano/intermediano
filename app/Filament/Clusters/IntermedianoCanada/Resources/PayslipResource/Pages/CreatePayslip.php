<?php

namespace App\Filament\Clusters\IntermedianoCanada\Resources\PayslipResource\Pages;

use App\Filament\Clusters\IntermedianoCanada\Resources\PayslipResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePayslip extends CreateRecord
{
    protected static string $resource = PayslipResource::class;
}
