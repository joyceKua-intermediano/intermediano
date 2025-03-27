<?php

namespace App\Filament\Employee\Resources\EmployeeExpensesResource\Pages;

use App\Filament\Employee\Resources\EmployeeExpensesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployeeExpenses extends CreateRecord
{
    protected static string $resource = EmployeeExpensesResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
