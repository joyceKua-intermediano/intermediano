<?php

namespace App\Filament\Clusters\IntermedianoDoBrasilLtda\Resources\EmployeeExpensesResource\Pages;

use App\Filament\Clusters\IntermedianoDoBrasilLtda\Resources\EmployeeExpensesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeExpenses extends EditRecord
{
    protected static string $resource = EmployeeExpensesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
