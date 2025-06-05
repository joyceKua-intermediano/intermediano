<?php

if (!function_exists('calculateBrasilQuotation')) {
    function calculateBrasilQuotation($record, $previousMonthRecord)
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

        $inss = $totalGrossIncome * 0.2780;
        $fgts = $totalGrossIncome * 0.08;
        $fgtsFine = $totalGrossIncome * 0.04;
        $fgtsInss = $totalGrossIncome * 0.071539;
        $medicalInsurance =  $record->payrollCosts->medical_insurance;
        $mealTicket =  $record->payrollCosts->meal;
        $transportationTicket =  $record->payrollCosts->transportation;

        $payrollCostsTotal =
            $inss +
            $fgts +
            $fgtsFine +
            $fgtsInss +
            $medicalInsurance +
            $mealTicket +
            $transportationTicket;

        $salary13th = 0.0833333 * $totalGrossIncome;
        $vacation = 0.0833333 * $totalGrossIncome;
        $vacationBonus = 0.0278 * $totalGrossIncome;
        $termination = 0.0833333 * $totalGrossIncome;
        $provisionsTotal = $salary13th + $vacation + $vacationBonus + $termination;

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

        $accumulatedSalary13th = (0.0833 * $previousMonthGrossIncome) + $salary13th;
        $accumulatedVacation = (0.0833 * $previousMonthGrossIncome) + $vacation;
        $accumulatedVacationBonus = (0.0278 * $previousMonthGrossIncome) + $vacationBonus;
        $accumulatedTermination = (0.0833 * $previousMonthGrossIncome) + $termination;

        $accumulatedProvisionsTotal = $accumulatedSalary13th + $accumulatedVacation + $accumulatedVacationBonus + $accumulatedTermination;

        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100) ;
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee + $bankFee;
        $municipalTax = 0 * $subTotal;
        $servicesTaxes = ($subTotalGrossPayroll + $fee) * 0.0695;
        $totalInvoice = $subTotal + $municipalTax + $servicesTaxes;

        return [
            'grossSalary' => $grossSalary,
            'totalGrossIncome' => $totalGrossIncome,
            'subTotalGrossPayroll' => $subTotalGrossPayroll,
            'fee' => $fee,
            'bankFee' => $bankFee,
            'subTotal' => $subTotal,
            'municipalTax' => $municipalTax,
            'servicesTaxes' => $servicesTaxes,
            'totalInvoice' => $totalInvoice,
            'inss' => $inss,
            'fgts' => $fgts,
            'fgtsFine' => $fgtsFine,
            'fgtsInss' => $fgtsInss,
            'medicalInsurance' => $medicalInsurance,
            'mealTicket' => $mealTicket,
            'transportationTicket' => $transportationTicket,
            'payrollCostsTotal' => $payrollCostsTotal,
            'salary13th' => $salary13th,
            'vacation' => $vacation,
            'vacationBonus' => $vacationBonus,
            'termination' => $termination,
            'provisionsTotal' => $provisionsTotal,
            'previousMonthGrossIncome' => $previousMonthGrossIncome,
            'accumulatedSalary13th' => $accumulatedSalary13th,
            'accumulatedVacation' => $accumulatedVacation,
            'accumulatedVacationBonus' => $accumulatedVacationBonus,
            'accumulatedTermination' => $accumulatedTermination,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
        ];
    }
}
