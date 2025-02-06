<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithMapping;

class QuotationExport implements FromView,  WithEvents
{
    protected $record;

    public function __construct($record, $previousMonthRecord, $isQuotation = false)
    {
        $this->record = $record;
        $this->previousMonthRecord = $previousMonthRecord;
        $this->isQuotation = $isQuotation;
    }


    public function view(): View
    {
        $isIntegral = $this->record->is_integral;
        switch (true) {
            case  $this->record->cluster_name === 'IntermedianoColombiaSAS':
                $exportFile = $isIntegral ? 'exports.integral_quotation' : 'exports.quotation';
                break;
            case  $this->record->cluster_name === 'IntermedianoEcuadorSAS':
                $exportFile = 'exports.quotations.ecuador';
                break;
            default:
                # code...
                break;
        }
        return view($exportFile, [
            'record' => $this->record,
            'previousMonthRecord' => $this->previousMonthRecord,
            'isQuotation' => $this->isQuotation
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'B1:D45';

                $event->sheet->getDelegate()->getStyle($cellRange)->getBorders()->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->getColor()->setARGB('4f4f4f');


                $event->sheet->getDelegate()->getStyle($cellRange)->getBorders()->getTop()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->getColor()->setARGB('4f4f4f');
                $event->sheet->getDelegate()->getStyle($cellRange)->getBorders()->getBottom()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->getColor()->setARGB('4f4f4f');
                $event->sheet->getDelegate()->getStyle($cellRange)->getBorders()->getLeft()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->getColor()->setARGB('4f4f4f');
                $event->sheet->getDelegate()->getStyle($cellRange)->getBorders()->getRight()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->getColor()->setARGB('4f4f4f');
            },
        ];
    }
}
