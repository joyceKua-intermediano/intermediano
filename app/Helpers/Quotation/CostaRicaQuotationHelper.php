<?php

if (!function_exists('calculateCostaRicaQuotation')) {
    function calculateCostaRicaQuotation($record, $previousMonthRecord)
    {

        $grossSalary = $record->gross_salary;

        // Ordinary
        $totalGrossIncome =
            $record->gross_salary +
            $record->bonus +
            $record->home_allowance +
            $record->transport_allowance +
            $record->medical_allowance +
            $record->internet_allowance;

        $employerTaxes = ($totalGrossIncome - $record->medical_allowance) * 0.2667;
        $insPolicy = ($totalGrossIncome - $record->medical_allowance) * 0.0196;
        $medicalInsurance = ($totalGrossIncome - $record->medical_allowance) * $record->payroll_cost_medical_insurance / 100;

        $payrollCostsTotal =
            $employerTaxes +
            $insPolicy +
            $medicalInsurance;

        $unEmployment = 0.0533 * $totalGrossIncome;
        $forewarning = 0.0833 * $totalGrossIncome;
        $bonus = 0.0833 * $totalGrossIncome;
        $vacation = 0.0417 * $totalGrossIncome;
        $provisionsTotal = $unEmployment + $forewarning + $bonus + $vacation;

        // accumulated provision
        if ($previousMonthRecord) {
            $previousMonthGrossIncome = $previousMonthRecord->gross_salary +
                $previousMonthRecord->bonus +
                $previousMonthRecord->home_allowance +
                $previousMonthRecord->transport_allowance +
                $previousMonthRecord->medical_allowance +
                $previousMonthRecord->internet_allowance;
        } else {
            $previousMonthGrossIncome = 0;
        };

        $accumulatedUnEmployment = (0.0533 * $previousMonthGrossIncome) + $unEmployment;
        $accumulatedForewarning = (0.0833 * $previousMonthGrossIncome) + $forewarning;
        $accumulatedBonus = (0.0833 * $previousMonthGrossIncome) + $bonus;
        $accumulatedVacation = (0.0417 * $previousMonthGrossIncome) + $vacation;

        $accumulatedProvisionsTotal = $accumulatedUnEmployment + $accumulatedForewarning + $accumulatedBonus + $accumulatedVacation;

        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $subTotalGrossPayroll * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee + $bankFee;
        $municipalTax = 0 * $subTotal;
        $servicesTaxes = ($municipalTax + $subTotal) * 0.13;
        $totalInvoice = $subTotal + $municipalTax + $servicesTaxes;

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
            'employerTaxes' => $employerTaxes,
            'insPolicy' => $insPolicy,
            'medicalInsurance' => $medicalInsurance,
            'payrollCostsTotal' => $payrollCostsTotal,
            'unEmployment' => $unEmployment,
            'forewarning' => $forewarning,
            'bonus' => $bonus,
            'vacation' => $vacation,
            'provisionsTotal' => $provisionsTotal,
            'previousMonthGrossIncome' => $previousMonthGrossIncome,
            'accumulatedUnEmployment' => $accumulatedUnEmployment,
            'accumulatedForewarning' => $accumulatedForewarning,
            'accumulatedBonus' => $accumulatedBonus,
            'accumulatedVacation' => $accumulatedVacation,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
        ];
    }
}
