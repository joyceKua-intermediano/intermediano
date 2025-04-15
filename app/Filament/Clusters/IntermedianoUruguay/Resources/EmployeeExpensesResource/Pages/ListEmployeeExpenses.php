<?php

namespace App\Filament\Clusters\IntermedianoUruguay\Resources\EmployeeExpensesResource\Pages;

use App\Filament\Clusters\IntermedianoUruguay\Resources\EmployeeExpensesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeExpenses extends ListRecords
{
    protected static string $resource = EmployeeExpensesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
