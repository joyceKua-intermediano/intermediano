<?php

if (!function_exists('calculatePeruQuotation')) {
    function calculatePeruQuotation($record, $previousMonthRecord)
    {

        $grossSalary = $record->gross_salary;

        // Ordinary
        $totalGrossIncome =
            $record->gross_salary +
            $record->bonus +
            $record->home_allowance +
            $record->transport_allowance +
            $record->family_allowance +
            $record->medical_allowance +
            $record->legal_grafication +
            $record->internet_allowance;

        $healthInsurance = ($totalGrossIncome - $record->medical_allowance) * 0.09;
        $healthInsuranceVacation = ($totalGrossIncome - $record->medical_allowance) * .0075;
        $eps = $record->payrollCosts->eps;
        $seguroVida = ($totalGrossIncome - $record->medical_allowance) * .003252;

        $payrollCostsTotal =
            $healthInsurance +
            $healthInsuranceVacation +
            $eps +
            $seguroVida;

        $gratification = 0.1667 * $totalGrossIncome;
        $extraOrdinaryGratification = .0150 * $totalGrossIncome;
        $vacation = .0973 * $totalGrossIncome;
        $cts = .0973 * $totalGrossIncome;
        $termination = .1250 * $totalGrossIncome;

        $provisionsTotal = $gratification + $extraOrdinaryGratification + $vacation + $cts + $termination;

        // accumulated provision
        if ($previousMonthRecord) {
            $previousMonthGrossIncome = $previousMonthRecord->gross_salary +
                $previousMonthRecord->bonus +
                $previousMonthRecord->home_allowance +
                $previousMonthRecord->family_allowance +
                $previousMonthRecord->transport_allowance +
                $previousMonthRecord->medical_allowance +
                $previousMonthRecord->legal_grafication +
                $previousMonthRecord->internet_allowance;
        } else {
            $previousMonthGrossIncome = 0;
        };
        $accumulatedGratification = (0.1667 * $previousMonthGrossIncome) + $gratification;
        $accumulatedExtraOrdinaryGratification = (0.0150 * $previousMonthGrossIncome) + $extraOrdinaryGratification;
        $accumulatedVacation = (0.0973 * $previousMonthGrossIncome) + $vacation;
        $accumulatedCts = (0.0973 * $previousMonthGrossIncome) + $cts;
        $accumulatedTermination = (0.1250 * $previousMonthGrossIncome) + $termination;


        $accumulatedProvisionsTotal = $accumulatedGratification + $accumulatedExtraOrdinaryGratification + $accumulatedVacation + $accumulatedCts + $accumulatedTermination;

        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee + $bankFee;
        $municipalTax = 0 * $subTotal;
        $servicesTaxes = $subTotal * 0.18;
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
            'healthInsurance' => $healthInsurance,
            'healthInsuranceVacation' => $healthInsuranceVacation,
            'eps' => $eps,
            'seguroVida' => $seguroVida,
            'gratification' => $gratification,
            'extraOrdinaryGratification' => $extraOrdinaryGratification,
            'vacation' => $vacation,
            'cts' => $cts,
            'termination' => $termination,
            'previousMonthGrossIncome' => $previousMonthGrossIncome,
            'accumulatedGratification' => $accumulatedGratification,
            'accumulatedExtraOrdinaryGratification' => $accumulatedExtraOrdinaryGratification,
            'accumulatedVacation' => $accumulatedVacation,
            'accumulatedCts' => $accumulatedCts,
            'accumulatedTermination' => $accumulatedTermination,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
        ];
    }
}
