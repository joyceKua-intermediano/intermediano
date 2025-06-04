<?php

if (!function_exists('calculateElSalvadorQuotation')) {
    function calculateElSalvadorQuotation($record, $previousMonthRecord)
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

        $iss = $totalGrossIncome * 0.075;
        $insaforp = $totalGrossIncome * 0.01;
        $afp = $totalGrossIncome * 0.0775;

        $payrollCostsTotal = $iss + $insaforp + $afp;

        $compensation = 0.0417 * $totalGrossIncome;
        $vacations = 0.0417 * $totalGrossIncome;
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

        $accumulatedCompensation = (0.0417 * $previousMonthGrossIncome) + $compensation;
        $accumulatedChristmasBonus = (0.0833 * $previousMonthGrossIncome) + $christmasBonus;
        $accumulatedVacations = (0.0417 * $previousMonthGrossIncome) + $vacations;

        $accumulatedProvisionsTotal = $accumulatedCompensation + $accumulatedChristmasBonus + $accumulatedVacations;
        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee + $bankFee;
        $servicesTaxes = $subTotal * 0.13;
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
            'servicesTaxes' => $servicesTaxes,
            'totalInvoice' => $totalInvoice,
            'iss' => $iss,
            'insaforp' => $insaforp,
            'afp' => $afp,
            'compensation' => $compensation,
            'christmasBonus' => $christmasBonus,
            'vacations' => $vacations,
            'previousMonthGrossIncome' => $previousMonthGrossIncome,
            'accumulatedCompensation' => $accumulatedCompensation,
            'accumulatedChristmasBonus' => $accumulatedChristmasBonus,
            'accumulatedVacations' => $accumulatedVacations,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
        ];
    }
}
