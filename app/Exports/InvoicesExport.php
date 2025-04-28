<?php

namespace App\Exports;

use App\Models\Invoice;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InvoicesExport implements FromCollection, WithHeadings, WithStyles
{
    protected $currentMonthInvoices;
    protected $previousInvoices;
    protected $companyColors = [];

    public function __construct($currentMonthInvoices, $previousInvoices)
    {
        $this->currentMonthInvoices = $currentMonthInvoices;
        $this->previousInvoices = $previousInvoices;
        $this->generateCompanyColors();
    }

    protected function generateCompanyColors()
    {
        $companies = [];
        foreach ($this->currentMonthInvoices as $invoice) {
            $companyName = $invoice->company->name;
            if (!in_array($companyName, $companies)) {
                $companies[] = $companyName;
            }
        }

        $colors = [
            'FFD3D3',
            'D3FFD3',
            'D3D3FF',
            'FFFFD3',
            'FFD3FF',
            'D3FFFF',
            'E6D3FF',
            'FFE6D3',
            'D3FFE6',
            'E6FFD3'
        ];

        foreach ($companies as $index => $company) {
            $colorIndex = $index % count($colors);
            $this->companyColors[$company] = $colors[$colorIndex];
        }
    }

    public function collection()
    {
        $data = collect();
        $currentMonthTotal = 0;

        foreach ($this->currentMonthInvoices as $invoice) {
            $companyName = $invoice->company->name;
            $employeeName = $invoice->employee->name;
            foreach ($invoice->invoice_items as $item) {
                $itemTotal = $item['unit_price'] * $item['quantity'];
                $currentMonthTotal += $itemTotal;
                $fee = $item['fee'] ?? 0;
                $bankFee = $item['bank_fee'] ?? 0;
                $amountOut =  $itemTotal - ( $fee - $bankFee - $item['tax']);

                $data->push([
                    'Company' => $companyName,
                    'Invoice ID' => '000' . $invoice->id,
                    'Employee Name' => $employeeName,
                    // 'Description' => $item['description'],
                    // 'Quantity' => $item['quantity'],
                    'Invoices Amount' => 'USD              ' . number_format($item['unit_price'], 2),
                    'Amount Out' => 'USD              ' . number_format($amountOut, 2),
                    'Fee' => $fee,
                    'TAX' => $item['tax'],
                    'Bank Fees' => $bankFee,
                    // 'Total' => 'USD               ' . number_format($itemTotal, 2),
                ]);
            }
        }

        $previousTotal = $this->previousInvoices->reduce(function ($carry, $invoice) {
            foreach ($invoice->invoice_items as $item) {
                $carry += $item['unit_price'] * $item['quantity'];
            }
            return $carry;
        }, 0);

        $cumulativeTotal = $currentMonthTotal + $previousTotal;

        $data->push([
            'Company' => '',
            'Invoice ID' => '',
            'Employee Name' => '',
            // 'Description' => 'Total for the selected month',
            // 'Quantity' => '',
            'Invoices Amount' => '',
            'Amount Out' => '',
            'Fee' => '',
            'TAX' => '',
            'Bank Fees' => '',
            // 'Total' => 'USD              ' . number_format($currentMonthTotal, 2),
        ]);

        $data->push([
            'Company' => '',
            'Invoice ID' => '',
            'Employee Name' => '',
            // 'Description' => 'Accumulative total (up to the selected month)',
            // 'Quantity' => '',
            'Invoices Amount' => '',
            'Amount Out' => '',
            'Fee' => '',
            'TAX' => '',
            'Bank Fees' => '',
            // 'Total' => 'USD               ' . number_format($cumulativeTotal, 2),
        ]);

        return $data;
    }

    public function headings(): array
    {
        return [
            'Invoice ID',
            'Company',
            'Employee Name',
            // 'Description',
            // 'Quantity',
            'Invoices Amount',
            'Amount Out',
            'Fee',
            'TAX',
            'Bank Fees',
            // 'Total',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $styles = [];
        $rowCount = count($this->collection()) + 1; 

        $styles[1] = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFA0A0A0']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ]
        ];
        $sheet->getStyle('A2:G' . $rowCount)->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ]
        ]);


        $currentRow = 2;
        $collectionData = $this->collection();

        foreach ($collectionData as $index => $row) {
            if ($index >= count($collectionData) - 2) {
                continue;
            }

            $companyName = $row['Company'];
            if ($companyName && isset($this->companyColors[$companyName])) {
                $styles[$currentRow] = [
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => $this->companyColors[$companyName]]
                    ]
                ];
            }
            $currentRow++;
        }

        $styles[$rowCount - 1] = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFD3D3D3']
            ]
        ];

        $styles[$rowCount] = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFD3D3D3']
            ]
        ];
        foreach (range('A', 'G') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->getColumnDimension('C')->setAutoSize(false);
        $sheet->getColumnDimension('C')->setWidth(40);
        return $styles;
    }
}