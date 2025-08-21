<?php

namespace App\Helpers;

use Filament\Forms\Components\Fieldset;

class PayrollCostsFormHelper
{
    /**
     * Generate PayrollCosts fieldset for any country
     *
     * @param string $countryName
     * @param array $schema
     * @return \Filament\Forms\Components\Fieldset
     */
    public static function getPayrollCostsFieldset(string $countryName, array $schema): Fieldset
    {
        return Fieldset::make('PayrollCosts')
            ->relationship('payrollCosts')
            ->visible(fn (callable $get) =>
                \App\Models\Country::find($get('country_id'))?->name === $countryName
            )
            ->label('Payroll Costs')
            ->schema($schema);
    }
}