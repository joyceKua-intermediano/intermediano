<?php

if (!function_exists('calculatePanamaQuotation')) {
    function calculatePanamaQuotation($record, $previousMonthRecord)
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

        $css = $totalGrossIncome * 0.1225;
        $professionalRisk = $totalGrossIncome * 0.021;
        $educationalInsurance = $totalGrossIncome * 0.0150;

        $payrollCostsTotal = $css + $professionalRisk + $educationalInsurance;

        $christmasBonus = 0.1007 * $totalGrossIncome;
        $vacations = 0.1053 * $totalGrossIncome;
        $forewarning = 0.0909 * $totalGrossIncome;
        $severance = 0.0713 * $totalGrossIncome;
        $seniority = 0.0210 * $totalGrossIncome;
        $provisionsTotal = $christmasBonus + $vacations + $forewarning + $severance + $seniority;

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
        $accumulatedChristmasBonus = (0.1007 * $previousMonthGrossIncome) + $christmasBonus;
        $accumulatedVacations = (0.1053 * $previousMonthGrossIncome) + $vacations;
        $accumulatedForewarning = (0.0909 * $previousMonthGrossIncome) + $forewarning;
        $accumulatedSeverance = (0.0713 * $previousMonthGrossIncome) + $severance;
        $accumulatedSeniority = (0.0210 * $previousMonthGrossIncome) + $seniority;

        $accumulatedProvisionsTotal = $accumulatedChristmasBonus + $accumulatedVacations + $accumulatedForewarning + $accumulatedSeverance + $accumulatedSeniority;

        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100);
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
            'css' => $css,
            'professionalRisk' => $professionalRisk,
            'educationalInsurance' => $educationalInsurance,
            'payrollCostsTotal' => $payrollCostsTotal,
            'christmasBonus' => $christmasBonus,
            'vacations' => $vacations,
            'forewarning' => $forewarning,
            'severance' => $severance,
            'seniority' => $seniority,
            'provisionsTotal' => $provisionsTotal,
            'previousMonthGrossIncome' => $previousMonthGrossIncome,
            'accumulatedChristmasBonus' => $accumulatedChristmasBonus,
            'accumulatedVacations' => $accumulatedVacations,
            'accumulatedForewarning' => $accumulatedForewarning,
            'accumulatedSeverance' => $accumulatedSeverance,
            'accumulatedSeniority' => $accumulatedSeniority,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
        ];
    }
}
