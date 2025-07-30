<?php

namespace App\Helpers;

use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;

class BrazilPayrollCostsFormHelper
{
    public static function getPayrollCostsFieldset(): Fieldset
    {
        return Fieldset::make('PayrollCosts')
            ->relationship('payrollCosts')
            ->visible(fn(callable $get) => \App\Models\Country::find($get('country_id'))?->name === 'Brazil')

            ->label('Payroll Costs')
            ->schema([
                TextInput::make('medical_insurance')->label('Medical Plan & Life Insurance'),
                TextInput::make('meal')->label('Meal tickets'),
                TextInput::make('transportation')->label('Transportation Tickets'),
                TextInput::make('operational_costs')->label('Operational Costs'),
            ]);
    }
}
