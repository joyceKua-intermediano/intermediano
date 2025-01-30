<?php

if (!function_exists('calculateIntegralQuotation')) {
    function calculateIntegralQuotation($record, $previousMonthRecord)
    {

        $grossSalary = $record->gross_salary;

        // Payroll costs
        $totalGrossIncome = $record->gross_salary + $record->bonus + $record->home_allowance;
        $pensionFund = ((($totalGrossIncome - $record->home_allowance - $record->transport_allowance) * 0.70)) * 0.12;
        $healthFund = (($totalGrossIncome - $record->home_allowance - $record->transport_allowance) * 0.70) * 0.085;
        $icbfContribution = ($totalGrossIncome - $record->home_allowance - $record->transport_allowance) * 0.03;
        $senaContribution = ($totalGrossIncome - $record->home_allowance - $record->transport_allowance) * 0.02;
        $arlContribution = (($totalGrossIncome - $record->home_allowance - $record->transport_allowance) * 0.70) * 0.0244;
        $compensationFundContribution = ($totalGrossIncome - $record->home_allowance - $record->transport_allowance) * 0.04;
        $payrollCostsTotal =
            $pensionFund +
            $healthFund +
            $icbfContribution +
            $senaContribution +
            $arlContribution +
            $compensationFundContribution;

        $vacation = 0.0417 * $totalGrossIncome;
        $indemnization = 0.056 * $totalGrossIncome;
        $provisionsTotal = $vacation + $indemnization;
        // accumulated provision
        if($previousMonthRecord) {
            $previousMonthGrossIncome = $previousMonthRecord->gross_salary +
            $previousMonthRecord->bonus +
            $previousMonthRecord->home_allowance +
            $previousMonthRecord->transport_allowance +
            $previousMonthRecord->medical_allowance;
        }else {
            $previousMonthGrossIncome = 0;
        };

        $accumulatedVacation = (0.0417 * $previousMonthGrossIncome) + $vacation;
        $accumulatedIndemnization = (0.056 * $previousMonthGrossIncome) + $indemnization;
        $accumulatedProvisionsTotal =  $accumulatedVacation + $accumulatedIndemnization;

        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $grossSalary * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee + $bankFee;
        $municipalTax = 0.01 * $subTotal;
        $servicesTaxes = ($municipalTax + $subTotal) * 0.19;
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
            'pensionFund' => $pensionFund,
            'healthFund' => $healthFund,
            'icbfContribution' => $icbfContribution,
            'senaContribution' => $senaContribution,
            'arlContribution' => $arlContribution,
            'compensationFundContribution' => $compensationFundContribution,
            'payrollCostsTotal' => $payrollCostsTotal,
            'vacation' => $vacation,
            'indemnization' => $indemnization,
            'provisionsTotal' => $provisionsTotal,
            'previousMonthGrossIncome' => $previousMonthGrossIncome,
            'accumulatedVacation' => $accumulatedVacation,
            'accumulatedIndemnization' => $accumulatedIndemnization,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
        ];
    }
}
