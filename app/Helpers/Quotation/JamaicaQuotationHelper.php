<?php

if (!function_exists('calculateJamaicaQuotation')) {
    function calculateJamaicaQuotation($record, $previousRecords)
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

        $employerNis = $totalGrossIncome * 0.03;
        $housingTaxEmployer = $totalGrossIncome * 0.03;
        $educationTaxEmployer = ($totalGrossIncome - $employerNis) * 0.035;
        $employerHeartTax = $totalGrossIncome * 0.03;

        $payrollCostsTotal = $employerNis + $housingTaxEmployer + $educationTaxEmployer + $employerHeartTax;

        $vacations = 0.0417 * $totalGrossIncome;
        $notice = 0.0417 * $totalGrossIncome;
        $redundancy = 0.0417 * $totalGrossIncome;

        $provisionsTotal = $redundancy + $vacations + $notice;

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

        $accumulatedRedundancy = (0.0417 * $previousMonthGrossIncome) + $redundancy;
        $accumulatedNotice = (0.0833 * $previousMonthGrossIncome) + $notice;
        $accumulatedVacations = (0.0417 * $previousMonthGrossIncome) + $vacations;

        $accumulatedProvisionsTotal = $accumulatedRedundancy + $accumulatedNotice + $accumulatedVacations;
        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee + $bankFee;
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
            'servicesTaxes' => $servicesTaxes,
            'totalInvoice' => $totalInvoice,
            'employerNis' => $employerNis,
            'housingTaxEmployer' => $housingTaxEmployer,
            'educationTaxEmployer' => $educationTaxEmployer,
            'employerHeartTax' => $employerHeartTax,
            'redundancy' => $redundancy,
            'notice' => $notice,
            'vacations' => $vacations,
            'previousMonthGrossIncome' => $previousMonthGrossIncome,
            'accumulatedRedundancy' => $accumulatedRedundancy,
            'accumulatedNotice' => $accumulatedNotice,
            'accumulatedVacations' => $accumulatedVacations,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
        ];
    }
}
