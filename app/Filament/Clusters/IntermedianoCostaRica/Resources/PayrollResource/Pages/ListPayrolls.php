<?php

namespace App\Filament\Clusters\IntermedianoCostaRica\Resources\PayrollResource\Pages;

use App\Filament\Clusters\IntermedianoCostaRica\Resources\PayrollResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPayrolls extends ListRecords
{
    protected static string $resource = PayrollResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
