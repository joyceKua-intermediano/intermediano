<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Collection;

class MonthlyInvoicesSheet implements FromCollection, WithTitle
{
    protected $month;
    protected $invoices;

    public function __construct($month, $invoices)
    {
        $this->month = $month;
        $this->invoices = $invoices;
    }

    public function collection()
    {
        $data = new Collection();
        $totalSum = 0;
        $startOfYear = now()->startOfYear(); // January 1st of the current year
        $endOfPreviousMonth = now()->subMonth()->endOfMonth(); // End of the previous month

        foreach ($this->invoices as $invoice) {
            $companyName = $invoice->company->name;
            $employeeName = $invoice->employee->name;

            $items = $invoice->invoice_items ?: [];

            $invoiceDate = Carbon::parse($invoice->invoice_date);
            if ($invoiceDate->between($startOfYear, $endOfPreviousMonth)) {

                foreach ($items as $item) {
                    $itemTotal = $item['unit_price'] * $item['quantity'];
                    $totalSum += $itemTotal;
                    $data->push([
                        'Company' => $companyName,
                        'Invoice ID' => '000' . $invoice->id,
                        'Name' => $employeeName,
                        'Description' => $item['description'],
                        'Quantity' => $item['quantity'],
                        'Unit Price' => $item['unit_price'],
                        'Total' => $itemTotal,
                        'Tax' => $item['tax'],
                    ]);
                }
            }
        }

        $data->push([
            'Company' => '',
            'Invoice ID' => '',
            'Name' => '',
            'Description' => 'Total',
            'Quantity' => '',
            'Unit Price' => '',
            'Total' => $totalSum,
            'Tax' => '',
        ]);
        return $data;
    }

    public function title(): string
    {
        return $this->month;
    }
}