<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExpensesExport implements FromArray, WithHeadings
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Employee',
            'Company',
            'Description',
            'Date',
            'Amount',
            'Federal Amount',
            'State Amount',
            'BRL (Include Taxes)',
            'USD',
            'Exchange Rate',
            'BRL',
            'Status',
            'Comments',
            // 'Local Total',
            // 'Abroad Total',
            // 'Grand Total',
        ];
    }
}
