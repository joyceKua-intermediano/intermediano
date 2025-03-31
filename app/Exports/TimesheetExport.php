<?php

// app/Exports/TimesheetExport.php

namespace App\Exports;

use App\Models\MonthlyTimesheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TimesheetExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $timesheet;

    public function __construct(MonthlyTimesheet $timesheet)
    {
        $this->timesheet = $timesheet;
    }

    public function collection()
    {
        return collect([$this->timesheet]);
    }

    public function headings(): array
    {
        return [
            'Employee',
            'Month',
            'Year',
            ...array_map(fn($day) => "Day $day", range(1, 31)),
            'Total Hours'
        ];
    }

    public function map($timesheet): array
    {
        $monthName = date('F', mktime(0, 0, 0, $timesheet->month, 1));
        
        return [
            $timesheet->employee->name,
            $monthName,
            $timesheet->year,
            ...array_values($timesheet->days),
            array_sum($timesheet->days)
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A1:AF1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D9D9D9']]],
        ];
    }
}