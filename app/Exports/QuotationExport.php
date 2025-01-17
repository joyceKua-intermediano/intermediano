<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QuotationExport implements FromCollection, WithHeadings
{
    protected $record;

    public function __construct($record)
    {
        $this->record = $record;
    }

    public function collection()
    {
        return collect([
            [
                'Net Salary' => number_format($this->record->gross_salary - $this->record->deductions),
                'Deductions' => number_format($this->record->deductions),
                'Gross Salary' => number_format($this->record->gross_salary),
                'Bonus' => number_format($this->record->bonus),
                'Gross Monthly Salary' => number_format($this->record->gross_salary + $this->record->bonus),
                'Payroll Costs' => number_format($this->record->payroll_costs),
                'Provisions' => number_format($this->record->provisions),
                'Gross Salary + Payroll Costs & Provisions' => number_format($this->record->gross_salary + $this->record->payroll_costs + $this->record->provisions),
                'Fee' => number_format($this->record->fee),
                'Banking Fee' => number_format($this->record->banking_fee),
                'IRPJ' => number_format($this->record->irpj),
                'Total Partial' => number_format($this->record->gross_salary + $this->record->payroll_costs + $this->record->provisions + $this->record->bonus),
                'ISS' => number_format($this->record->iss),
                'Gross Payroll, PR Costs, Fees & Taxes' => number_format($this->record->gross_salary + $this->record->payroll_costs + $this->record->fee + $this->record->taxes),
            ],
        ]);
    }

    public function headings(): array
    {
        return [
            'Net Salary',
            'Deductions',
            'Gross Salary',
            'Bonus',
            'Gross Monthly Salary',
            'Payroll Costs',
            'Provisions',
            'Gross Salary + Payroll Costs & Provisions',
            'Fee',
            'Banking Fee',
            'IRPJ',
            'Total Partial',
            'ISS',
            'Gross Payroll, PR Costs, Fees & Taxes',
        ];
    }
}
