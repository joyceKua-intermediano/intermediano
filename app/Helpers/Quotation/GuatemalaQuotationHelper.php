<?php

if (!function_exists('calculateGuatemalaQuotation')) {
    function calculateGuatemalaQuotation($record, $previousRecords)
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
        $irtra = $totalGrossIncome * 0.010;
        $intecap = $totalGrossIncome * 0.010;
        $igss = $totalGrossIncome * 0.1067;

        $payrollCostsTotal = $irtra + $intecap + $igss;

        $annualBonus = 0.0833 * $totalGrossIncome;
        $christmasBonus = 0.0833 * $totalGrossIncome;

        $vacations = 0.0433 * $totalGrossIncome;
        $indemnity = 0.0972 * $totalGrossIncome;

        $provisionsTotal = $christmasBonus + $vacations + $annualBonus + $indemnity;

        // accumulated provision
        if ($previousRecords && $previousRecords->count()) {
            $previousMonthGrossIncome = $previousRecords->gross_salary +
                $previousRecords->bonus +
                $previousRecords->home_allowance +
                $previousRecords->transport_allowance +
                $previousRecords->medical_allowance +
                $previousRecords->legal_grafication +
                $previousRecords->internet_allowance;
        } else {
            $previousMonthGrossIncome = 0;
        };

        $accumulatedChristmasBonus = (0.0417 * $previousMonthGrossIncome) + $christmasBonus;
        $accumulatedAnnualBonus = (0.0417 * $previousMonthGrossIncome) + $annualBonus;
        $accumulatedIndemnity = (0.0417 * $previousMonthGrossIncome) + $indemnity;
        $accumulatedVacations = (0.0417 * $previousMonthGrossIncome) + $vacations;

        $accumulatedProvisionsTotal = $accumulatedChristmasBonus + $accumulatedAnnualBonus + $accumulatedIndemnity + $accumulatedVacations;
        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee + $bankFee;
        $servicesTaxes = $subTotal * 0.12;
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
            'irtra' => $irtra,
            'intecap' => $intecap,
            'igss' => $igss,
            'christmasBonus' => $christmasBonus,
            'annualBonus' => $annualBonus,
            'indemnity' => $indemnity,
            'vacations' => $vacations,
            'previousMonthGrossIncome' => $previousMonthGrossIncome,
            'accumulatedChristmasBonus' => $accumulatedChristmasBonus,
            'accumulatedAnnualBonus' => $accumulatedAnnualBonus,
            'accumulatedIndemnity' => $accumulatedIndemnity,
            'accumulatedVacations' => $accumulatedVacations,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
        ];
    }
}
