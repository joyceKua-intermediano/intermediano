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

class QuotationExport implements FromView, WithEvents
{
    protected $record;

    public function __construct($record, $previousRecords, $isQuotation = false)
    {
        $this->record = $record;
        $this->previousRecords = $previousRecords;
        $this->isQuotation = $isQuotation;
    }


    public function view(): View
    {
        $isIntegral = $this->record->is_integral;
        switch (true) {
            case $this->record->is_freelance === 1:
                $exportFile = 'exports.quotations.freelance';
                break;
            case $this->record->cluster_name === 'IntermedianoColombiaSAS':
                $exportFile = $isIntegral ? 'exports.integral_quotation' : 'exports.quotation';
                break;
            case $this->record->cluster_name === 'IntermedianoEcuadorSAS':
                $exportFile = 'exports.quotations.ecuador';
                break;
            case $this->record->cluster_name === 'IntermedianoCostaRica':
                $exportFile = 'exports.quotations.costa_rica';
                break;

            case $this->record->cluster_name === 'IntermedianoDoBrasilLtda':
                $exportFile = 'exports.quotations.brasil';
                break;
            case $this->record->cluster_name === 'IntermedianoMexicoSC':
                $exportFile = 'exports.quotations.mexico';
                break;
            case $this->record->cluster_name === 'IntermedianoChileSPA':
                $exportFile = 'exports.quotations.chile';
                break;
            case $this->record->cluster_name === 'IntermedianoPeruSAC':
                $exportFile = 'exports.quotations.peru';
                break;
            case $this->record->cluster_name === 'IntermedianoCanada' && $this->record->country->name === 'Brazil':
                $exportFile = 'exports.quotations.brasil';
                break;
            case $this->record->cluster_name === 'PartnerHongkong' && $this->record->country->name === 'Brazil':
                $exportFile = 'exports.quotations.brasil';
                break;
            case $this->record->cluster_name === 'IntermedianoCanada':
                $exportFile = 'exports.quotations.canada';
                break;
            case $this->record->cluster_name === 'PartnerUruguay' && $this->record->country->name === 'Brazil':
                $exportFile = 'exports.quotations.brasil';
                break;
            case $this->record->cluster_name === 'PartnerCanada' && $this->record->country->name === 'Brazil':
                $exportFile = 'exports.quotations.brasil';
                break;
            case $this->record->cluster_name === 'IntermedianoUruguay':
                $exportFile = 'exports.quotations.uruguay';
                break;
            case $this->record->cluster_name === 'IntermedianoHongkong':
                $exportFile = 'exports.quotations.hongkong';
                break;
            case $this->record->cluster_name === 'PartnerUruguay' && $this->record->country->name === 'Panama':
                $exportFile = 'exports.quotations.panama';
                break;
            case $this->record->cluster_name === 'PartnerUruguay' && $this->record->country->name === 'Nicaragua':
                $exportFile = 'exports.quotations.nicaragua';
                break;
            case $this->record->cluster_name === 'PartnerUruguay' && $this->record->country->name === 'Dominican Republic':
                $exportFile = 'exports.quotations.dominican_republic';
                break;
            case $this->record->cluster_name === 'PartnerUruguay' && $this->record->country->name === 'El Salvador':
                $exportFile = 'exports.quotations.el_salvador';
                break;
            case $this->record->cluster_name === 'PartnerUruguay' && $this->record->country->name === 'Honduras':
                $exportFile = 'exports.quotations.honduras';
                break;
            case $this->record->cluster_name === 'PartnerUruguay' && $this->record->country->name === 'Guatemala':
                $exportFile = 'exports.quotations.guatemala';
                break;
            case $this->record->cluster_name === 'PartnerUruguay' && $this->record->country->name === 'Jamaica':
                $exportFile = 'exports.quotations.jamaica';
                break;
            case $this->record->cluster_name === 'PartnerUruguay' && $this->record->country->name === 'Argentina':
                $exportFile = 'exports.quotations.argentina';
                break;
            case $this->record->cluster_name === 'PartnerCostaRica' && $this->record->country->name === 'Panama':
                $exportFile = 'exports.quotations.panama';
                break;

            default:
                # code...
                break;
        }
        return view($exportFile, [
            'record' => $this->record,
            'previousRecords' => $this->previousRecords,
            'isQuotation' => $this->isQuotation
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'B1:D61';

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
