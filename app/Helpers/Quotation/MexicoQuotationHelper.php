<?php

if (!function_exists('calculateMexicoQuotation')) {
    function calculateMexicoQuotation($record, $previousMonthRecord)
    {

        $grossSalary = $record->gross_salary;

        // Ordinary
        $totalGrossIncome =
            $record->gross_salary +
            $record->bonus +
            $record->transport_allowance +
            $record->food_allowance;
        $payrollTax = $totalGrossIncome * 0.04;
        $workRisk = $totalGrossIncome * 0.0266;
        $fixContribution = $totalGrossIncome * 0.0252;
        $cashBenefits = $totalGrossIncome * 0.0070;
        $disabilityInsurance = $totalGrossIncome * 0.0175;
        $kindergarten = $totalGrossIncome * 0.01;
        $pensionBeneficiaries = $totalGrossIncome * 0.0105;
        $retirement = $totalGrossIncome * 0.02;
        $oldAge = $totalGrossIncome * 0.06422;
        $infonavit = $totalGrossIncome * 0.05;


        $payrollCostsTotal =
            $payrollTax +
            $workRisk +
            $fixContribution +
            $cashBenefits +
            $disabilityInsurance +
            $kindergarten +
            $pensionBeneficiaries +
            $retirement +
            $oldAge +
            $infonavit;

        $salary13th = 0.0417 * $totalGrossIncome;
        $vacationPrime = 0.008333333 * $totalGrossIncome;
        $vacation = 0.0333333 * $totalGrossIncome;
        $indemnization90 = 0.25 * $totalGrossIncome;
        $indemnization20 = 0.0561 * $totalGrossIncome;
        $ptu = 0.01 * $totalGrossIncome;
        $provisionsTotal = $salary13th + $vacationPrime + $vacation + $indemnization90 + $indemnization20 + $ptu;

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

        $accumulatedSalary13th = (0.0417 * $previousMonthGrossIncome) + $salary13th;
        $accumulatedVacationPrime = (0.0833 * $previousMonthGrossIncome) + $vacationPrime;
        $accumulatedVacation = (0.0333 * $previousMonthGrossIncome) + $vacation;
        $accumulatedIndemnization90 = (0.025 * $previousMonthGrossIncome) + $indemnization90;
        $accumulatedIndemnization20 = (0.0561 * $previousMonthGrossIncome) + $indemnization20;
        $accumulatedPtu = (0.01 * $previousMonthGrossIncome) + $ptu;

        $accumulatedProvisionsTotal = $accumulatedSalary13th + $accumulatedVacationPrime + $accumulatedVacation + $accumulatedIndemnization90 + $accumulatedIndemnization20 + $accumulatedPtu;

        // end of accumulated provision
        $otherCost = $record->home_allowance + $record->internet_allowance + $record->medical_allowance ;
        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal + $otherCost;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100) ;
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee + $bankFee;
        $municipalTax = 0 * $subTotal;
        $servicesTaxes = $subTotal * 0.16;
        $totalInvoice = $bankFee + $servicesTaxes + $subTotal;

        return [
            'grossSalary' => $grossSalary,
            'totalGrossIncome' => $totalGrossIncome,
            'otherCost' => $otherCost,
            'subTotalGrossPayroll' => $subTotalGrossPayroll,
            'fee' => $fee,
            'bankFee' => $bankFee,
            'subTotal' => $subTotal,
            'municipalTax' => $municipalTax,
            'servicesTaxes' => $servicesTaxes,
            'totalInvoice' => $totalInvoice,
            'payrollTax' => $payrollTax,
            'workRisk' => $workRisk,
            'fixContribution' => $fixContribution,
            'cashBenefits' => $cashBenefits,
            'disabilityInsurance' => $disabilityInsurance,
            'kindergarten' => $kindergarten,
            'pensionBeneficiaries' => $pensionBeneficiaries,
            'retirement' => $retirement,
            'oldAge' => $oldAge,
            'infonavit' => $infonavit,
            'payrollCostsTotal' => $payrollCostsTotal,
            'salary13th' => $salary13th,
            'vacationPrime' => $vacationPrime,
            'vacation' => $vacation,
            'indemnization90' => $indemnization90,
            'indemnization20' => $indemnization20,
            'ptu' => $ptu,
            'provisionsTotal' => $provisionsTotal,
            'previousMonthGrossIncome' => $previousMonthGrossIncome,
            'accumulatedSalary13th' => $accumulatedSalary13th,
            'accumulatedVacationPrime' => $accumulatedVacationPrime,
            'accumulatedVacation' => $accumulatedVacation,
            'accumulatedIndemnization90' => $accumulatedIndemnization90,
            'accumulatedIndemnization20' => $accumulatedIndemnization20,
            'accumulatedPtu' => $accumulatedPtu,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
        ];
    }
}
