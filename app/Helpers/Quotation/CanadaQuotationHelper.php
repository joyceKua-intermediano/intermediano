<?php

if (!function_exists('calculateCanadaQuotation')) {
    function calculateCanadaQuotation($record, $previousMonthRecord)
    {

        $grossSalary = $record->gross_salary;

        // Ordinary
        $totalGrossIncome =
            $record->gross_salary +
            $record->bonus +
            $record->home_allowance +
            $record->transport_allowance +
            $record->medical_allowance +
            $record->legal_grafication +
            $record->internet_allowance;

        $canadanPension = $totalGrossIncome * .0595;
        $employmentInsurance = $totalGrossIncome * .0232 ;
        $employerHealthTax = $totalGrossIncome * 0.0195;
        $workerCompensation = $totalGrossIncome * .01;
        $glInsurance = $totalGrossIncome * .01;


        $payrollCostsTotal =
            $canadanPension +
            $employmentInsurance +
            $employerHealthTax +
            $workerCompensation +
            $glInsurance;

        $vacation = 0.0416 * $totalGrossIncome;
        $indemnification = 0.0833 * $totalGrossIncome;
        $provisionsTotal = $vacation + $indemnification;

        // accumulated provision
        if ($previousMonthRecord) {
            $previousMonthGrossIncome = $previousMonthRecord->gross_salary +
                $previousMonthRecord->bonus +
                $previousMonthRecord->home_allowance +
                $previousMonthRecord->transport_allowance +
                $previousMonthRecord->medical_allowance +
                $previousMonthRecord->legal_grafication +
                $previousMonthRecord->internet_allowance;
        } else {
            $previousMonthGrossIncome = 0;
        };
        $accumulatedVacation = (0.0416 * $previousMonthGrossIncome) + $vacation;
        $accumulatedIndemnification = (0.0833 * $previousMonthGrossIncome) + $indemnification;

        $accumulatedProvisionsTotal = $accumulatedVacation + $accumulatedIndemnification;

        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $totalGrossIncome * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee ;
        $municipalTax = 0 * $subTotal;
        $servicesTaxes = $subTotal * 0.19;
        $totalInvoice = $subTotal + $bankFee;

        return [
            'grossSalary' => $grossSalary,
            'totalGrossIncome' => $totalGrossIncome,
            'payrollCostsTotal' => $payrollCostsTotal,
            'provisionsTotal' => $provisionsTotal,
            'subTotalGrossPayroll' => $subTotalGrossPayroll,
            'fee' => $fee,
            'bankFee' => $bankFee,
            'subTotal' => $subTotal,
            'municipalTax' => $municipalTax,
            'servicesTaxes' => $servicesTaxes,
            'totalInvoice' => $totalInvoice,
            'canadanPension' => $canadanPension,
            'employmentInsurance' => $employmentInsurance,
            'employerHealthTax' => $employerHealthTax,
            'workerCompensation' => $workerCompensation,
            'glInsurance' => $glInsurance,
            'vacation' => $vacation,
            'indemnification' => $indemnification,
            'previousMonthGrossIncome' => $previousMonthGrossIncome,
            'accumulatedVacation' => $accumulatedVacation,
            'accumulatedIndemnification' => $accumulatedIndemnification,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
        ];
    }
}
