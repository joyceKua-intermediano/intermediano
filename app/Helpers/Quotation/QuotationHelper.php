<?php

if (!function_exists('calculateQuotation')) {
    function calculateQuotation($record, $previousMonthRecord)
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
        $pensionFund = ($totalGrossIncome - $record->medical_allowance - $record->home_allowance - $record->transport_allowance - $record->internet_allowance) * 0.12;
        $healthFund = ($totalGrossIncome - $record->medical_allowance - $record->home_allowance - $record->transport_allowance - $record->internet_allowance) * 0.085;
        $icbfContribution = ($totalGrossIncome - $record->medical_allowance - $record->home_allowance - $record->transport_allowance - $record->internet_allowance) * 0.03;
        $senaContribution = ($totalGrossIncome - $record->medical_allowance - $record->home_allowance - $record->transport_allowance - $record->internet_allowance) * 0.02;
        $arlContribution = ($totalGrossIncome - $record->medical_allowance - $record->home_allowance - $record->transport_allowance - $record->internet_allowance) * 0.0244;
        $compensationFundContribution = ($totalGrossIncome - $record->medical_allowance - $record->home_allowance - $record->transport_allowance - $record->internet_allowance) * 0.04;
        
        $payrollCostsTotal =
            $pensionFund +
            $healthFund +
            $icbfContribution +
            $senaContribution +
            $arlContribution +
            $compensationFundContribution;

        $cesantias = 0.0833 * $totalGrossIncome;
        $interestDeCesantias = $cesantias * 0.12;
        $prima = 0.0833 * $totalGrossIncome;
        $vacation = 0.0417 * $totalGrossIncome;
        $indemnization = 0.056 * $totalGrossIncome;
        $provisionsTotal = $cesantias + $interestDeCesantias + $prima + $vacation + $indemnization;

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

        $accumulatedCesantias = (0.0833 * $previousMonthGrossIncome) + $cesantias;
        $accumulatedInterestDeCesantias = ((0.0833 * $previousMonthGrossIncome) * 0.12) + $interestDeCesantias;
        $accumulatedPrima = (0.0833 * $previousMonthGrossIncome) + $prima;
        $accumulatedVacation = (0.0417 * $previousMonthGrossIncome) + $vacation;
        $accumulatedIndemnization = (0.056 * $previousMonthGrossIncome) + $indemnization;
        $accumulatedProvisionsTotal = $accumulatedCesantias + $accumulatedInterestDeCesantias + $accumulatedPrima + $accumulatedVacation + $accumulatedIndemnization;

        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100) ;       
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
            'cesantias' => $cesantias,
            'interestDeCesantias' => $interestDeCesantias,
            'prima' => $prima,
            'vacation' => $vacation,
            'indemnization' => $indemnization,
            'provisionsTotal' => $provisionsTotal,
            'previousMonthGrossIncome' => $previousMonthGrossIncome,
            'accumulatedCesantias' => $accumulatedCesantias,
            'accumulatedInterestDeCesantias' => $accumulatedInterestDeCesantias,
            'accumulatedPrima' => $accumulatedPrima,
            'accumulatedVacation' => $accumulatedVacation,
            'accumulatedIndemnization' => $accumulatedIndemnization,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
        ];
    }
}
