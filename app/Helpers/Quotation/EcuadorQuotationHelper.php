<?php

if (!function_exists('calculateEcuadorQuotation')) {
    function calculateEcuadorQuotation($record, $previousMonthRecord)
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

        $iess = $totalGrossIncome * 0.1115;
        $secap = $totalGrossIncome * 0.005;
        $iece = $totalGrossIncome * 0.005;
        $payrollCostsTotal =
            $iess +
            $secap +
            $iece;

        $vacation = 0.0417 * $totalGrossIncome;
        $reserveFund = 0.08333 * $totalGrossIncome;
        $bonus13th = 0.08333 * $totalGrossIncome;
        $bonus14th = 0.08333 * 470;
        $bonification = .0208 * $totalGrossIncome;
        $compensation = 0.25 * $totalGrossIncome;
        $provisionsTotal = $vacation + $reserveFund + $bonus13th + $bonus14th + $bonification + $compensation;

        // accumulated provision
        if($previousMonthRecord) {
            $previousMonthGrossIncome = $previousMonthRecord->gross_salary +
            $previousMonthRecord->bonus +
            $previousMonthRecord->home_allowance +
            $previousMonthRecord->transport_allowance +
            $previousMonthRecord->medical_allowance +
            $previousMonthRecord->internet_allowance;
        }else {
            $previousMonthGrossIncome = 0;
        };

        $accumulatedVacation = (0.0417 * $previousMonthGrossIncome) + $vacation;
        $accumulatedReserveFund = ((0.08333 * $previousMonthGrossIncome)) + $reserveFund;
        $accumulatedBonus13th = (0.08333 * $previousMonthGrossIncome) + $bonus13th;
        $accumulatedBonus14th = (0.08333 * 470) + $bonus14th;
        $accumulatedBonification = (0.0208 * $previousMonthGrossIncome) + $bonification;
        $accumulatedCompensation = (0.25 * $previousMonthGrossIncome) + $compensation;
        $accumulatedProvisionsTotal = $accumulatedVacation + $accumulatedReserveFund + $accumulatedBonus13th + $accumulatedBonus14th + $accumulatedBonification + $accumulatedCompensation;

        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $subTotalGrossPayroll * ($record->fee / 100);
        $bankFee = $record->bank_fee;
        $subTotal = $subTotalGrossPayroll + $fee + $bankFee;
        $municipalTax = 0 * $subTotal;
        $servicesTaxes = ($municipalTax + $subTotal) * 0;
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
            'iess' => $iess,
            'secap' => $secap,
            'iece' => $iece,
            'payrollCostsTotal' => $payrollCostsTotal,
            'vacation' => $vacation,
            'reserveFund' => $reserveFund,
            'bonus13th' => $bonus13th,
            'bonus14th' => $bonus14th,
            'bonification' => $bonification,
            'compensation' => $compensation,
            'provisionsTotal' => $provisionsTotal,
            'previousMonthGrossIncome' => $previousMonthGrossIncome,
            'accumulatedVacation' => $accumulatedVacation,
            'accumulatedReserveFund' => $accumulatedReserveFund,
            'accumulatedBonus13th' => $accumulatedBonus13th,
            'accumulatedBonus14th' => $accumulatedBonus14th,
            'accumulatedBonification' => $accumulatedBonification,
            'accumulatedCompensation' => $accumulatedCompensation,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
        ];
    }
}
