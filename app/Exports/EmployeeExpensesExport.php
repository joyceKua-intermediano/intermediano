<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeeExpensesExport implements
    FromArray,
    WithHeadings,
    WithStyles,
    WithCustomStartCell,
    WithTitle,
    WithEvents
{
    protected $data;
    protected $company;
    protected $costCenter;
    protected $totalBRL = 0;

    public function __construct(array $data, string $company, string $costCenter)
    {
        $this->data = $data;
        $this->company = $company;
        $this->costCenter = $costCenter;

        foreach ($data as $expense) {
            $brlValue = $expense['BRL (Include Taxes)'] ?? 0;
            $this->totalBRL += is_numeric($brlValue) ? floatval($brlValue) : 0;
        }
    }

    public function array(): array
    {
        return $this->data;
    }

    public function title(): string
    {
        return 'Expenses Report';
    }

    public function startCell(): string
    {
        return 'A5';
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
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:B1');
        $formattedCompany = preg_replace('/(?<!^)([A-Z])/', ' $1', $this->company);

        $sheet->setCellValue('A1', 'Group Company: ' . $formattedCompany);

        $sheet->mergeCells('A2:B2');
        $sheet->setCellValue('A2', 'Cost Center: ' . $this->costCenter);

        $headerStyles = [
            'font' => ['bold' => true, 'size' => 12],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'E6E6E6']]
        ];

        $sheet->getStyle('A1:A2')->applyFromArray($headerStyles);

        return [
            5 => ['font' => ['bold' => true]],
            'A5:M5' => ['fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D9D9D9']]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastRow = count($this->data) + 5; 

                $event->sheet->setCellValue("H" . ($lastRow + 1), $this->totalBRL);
                $event->sheet->setCellValue("G" . ($lastRow + 1), "Total BRL:");

                $event->sheet->getStyle("G" . ($lastRow + 1) . ":H" . ($lastRow + 1))->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'E6E6E6']]
                ]);

                $event->sheet->getStyle("H" . ($lastRow + 1))->getNumberFormat()
                    ->setFormatCode('#,##0.00');
            }
        ];
    }
}
