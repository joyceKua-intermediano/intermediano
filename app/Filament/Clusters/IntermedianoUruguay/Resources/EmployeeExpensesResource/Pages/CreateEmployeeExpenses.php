<?php

namespace App\Filament\Clusters\IntermedianoUruguay\Resources\EmployeeExpensesResource\Pages;

use App\Filament\Clusters\IntermedianoUruguay\Resources\EmployeeExpensesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployeeExpenses extends CreateRecord
{
    protected static string $resource = EmployeeExpensesResource::class;
    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }
}
