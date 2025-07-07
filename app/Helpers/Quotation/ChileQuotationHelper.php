<?php

if (!function_exists('calculateChileQuotation')) {
    function calculateChileQuotation($record, $previousMonthRecord)
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

        $employerContribution = $totalGrossIncome * 0.0375;
        $unEmploymentInsurance = $totalGrossIncome * 0.03;
        $disabilityInsurance = $totalGrossIncome * 0.0199;
        // dd($record->payrollCosts);
        $insurance = 0.53 * $record->payrollCosts->uf_month;
        $operationalCosts = 1.2397 * $record->payrollCosts->uf_month;

        $payrollCostsTotal =
            $employerContribution +
            $unEmploymentInsurance +
            $disabilityInsurance +
            $insurance +
            $operationalCosts;

        $vacation = 0.058333 * $totalGrossIncome;
        $compensation = 0.0833 * $totalGrossIncome;
        $noticePeriod = 0.0833 * $totalGrossIncome;
        $provisionsTotal = $vacation + $compensation + $noticePeriod;

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
        $accumulatedVacation = (0.058333 * $previousMonthGrossIncome) + $vacation;
        $accumulatedCompensation = (0.0833 * $previousMonthGrossIncome) + $compensation;
        $accumulatedNoticePeriod = (0.0833 * $previousMonthGrossIncome) + $noticePeriod;

        $accumulatedProvisionsTotal = $accumulatedVacation + $accumulatedCompensation + $accumulatedNoticePeriod;

        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee + $bankFee;
        $municipalTax = 0 * $subTotal;
        $servicesTaxes = $subTotal * 0.19;
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
            'employerContribution' => $employerContribution,
            'unEmploymentInsurance' => $unEmploymentInsurance,
            'disabilityInsurance' => $disabilityInsurance,
            'insurance' => $insurance,
            'operationalCosts' => $operationalCosts,
            'vacation' => $vacation,
            'compensation' => $compensation,
            'noticePeriod' => $noticePeriod,
            'previousMonthGrossIncome' => $previousMonthGrossIncome,
            'accumulatedVacation' => $accumulatedVacation,
            'accumulatedCompensation' => $accumulatedCompensation,
            'accumulatedNoticePeriod' => $accumulatedNoticePeriod,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
        ];
    }
}
