<?php

if (!function_exists('calculateNicaraguaQuotation')) {
    function calculateNicaraguaQuotation($record, $previousMonthRecord)
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

        $inssPatronal = $totalGrossIncome * 0.2250;
        $inatec = $totalGrossIncome * 0.02;

        $payrollCostsTotal = $inssPatronal + $inatec;

        $compensation = 0.0833 * $totalGrossIncome;
        $vacations = 0.0833 * $totalGrossIncome;
        $christmasBonus = 0.0833 * $totalGrossIncome;
        $provisionsTotal = $compensation + $vacations + $christmasBonus;

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

        $accumulatedCompensation = (0.0833 * $previousMonthGrossIncome) + $compensation;
        $accumulatedChristmasBonus = (0.0833 * $previousMonthGrossIncome) + $christmasBonus;
        $accumulatedVacations = (0.0833 * $previousMonthGrossIncome) + $vacations;

        $accumulatedProvisionsTotal = $accumulatedCompensation + $accumulatedChristmasBonus + $accumulatedVacations;
        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee + $bankFee;
        $municipalTax = 0 * $subTotal;
        $servicesTaxes = $subTotal * 0.15;
        $totalInvoice = $subTotal + $servicesTaxes;

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
            'inssPatronal' => $inssPatronal,
            'inatec' => $inatec,
            'payrollCostsTotal' => $payrollCostsTotal,
            'compensation' => $compensation,
            'christmasBonus' => $christmasBonus,
            'vacations' => $vacations,
            'provisionsTotal' => $provisionsTotal,
            'previousMonthGrossIncome' => $previousMonthGrossIncome,
            'accumulatedCompensation' => $accumulatedCompensation,
            'accumulatedChristmasBonus' => $accumulatedChristmasBonus,
            'accumulatedVacations' => $accumulatedVacations,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
        ];
    }
}
