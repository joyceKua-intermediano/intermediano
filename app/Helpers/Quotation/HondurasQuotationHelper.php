<?php

if (!function_exists('calculateHondurasQuotation')) {
    function calculateHondurasQuotation($record, $previousRecords)
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
        $cappedAmount = 13156.53;
        $rap = ($totalGrossIncome - $cappedAmount) * 0.0150;
        $ivm = $cappedAmount * 0.0350;
        $ihss = $cappedAmount * 0.05;
        $professionalRisk = $cappedAmount * 0.002;
        $infop = $totalGrossIncome * 0.012;

        $payrollCostsTotal = $rap + $ivm + $ihss + $professionalRisk + $infop;

        $vacations = 0.0433 * $totalGrossIncome;
        $christmasBonus = 0.0833 * $totalGrossIncome;
        $bonus = 0.0833 * $totalGrossIncome;
        $severancePay = 0.0833 * $totalGrossIncome;
        $notice = 0.0833 * $totalGrossIncome;

        $provisionsTotal = $christmasBonus + $vacations + $notice + $bonus + $severancePay;

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
        }
        ;

        $accumulatedChristmasBonus = (0.0417 * $previousMonthGrossIncome) + $christmasBonus;
        $accumulatedBonus = (0.0417 * $previousMonthGrossIncome) + $bonus;
        $accumulatedSeverancePay = (0.0417 * $previousMonthGrossIncome) + $severancePay;
        $accumulatedNotice = (0.0833 * $previousMonthGrossIncome) + $notice;
        $accumulatedVacations = (0.0417 * $previousMonthGrossIncome) + $vacations;

        $accumulatedProvisionsTotal = $accumulatedChristmasBonus + $accumulatedBonus + $accumulatedSeverancePay + $accumulatedNotice + $accumulatedVacations;
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
            'rap' => $rap,
            'ivm' => $ivm,
            'ihss' => $ihss,
            'professionalRisk' => $professionalRisk,
            'infop' => $infop,
            'christmasBonus' => $christmasBonus,
            'bonus' => $bonus,
            'severancePay' => $severancePay,
            'notice' => $notice,
            'vacations' => $vacations,
            'previousMonthGrossIncome' => $previousMonthGrossIncome,
            'accumulatedChristmasBonus' => $accumulatedChristmasBonus,
            'accumulatedBonus' => $accumulatedBonus,
            'accumulatedSeverancePay' => $accumulatedSeverancePay,
            'accumulatedNotice' => $accumulatedNotice,
            'accumulatedVacations' => $accumulatedVacations,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
        ];
    }
}
