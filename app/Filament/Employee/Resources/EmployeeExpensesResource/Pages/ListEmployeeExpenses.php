<?php

namespace App\Filament\Employee\Resources\EmployeeExpensesResource\Pages;

use App\Filament\Employee\Resources\EmployeeExpensesResource;
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
