<?php

if (!function_exists('calculateUruguayQuotation')) {
    function calculateUruguayQuotation($record, $previousMonthRecord)
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

        $socialSecurity = ($totalGrossIncome * 0.18625)
            + (0.18625 * $totalGrossIncome * 0.055)
            + (0.13625 * $totalGrossIncome * 0.0833)
            + (($totalGrossIncome / 3 * 2 * 0.1943) * 0.18625) / 11.33;

        $operationalCosts = 50 * $record->exchange_rate;
        $payrollCostsTotal = $socialSecurity + $operationalCosts;

        $salary13th = ($totalGrossIncome * 0.0833) + (($totalGrossIncome / 3 * 2 * 0.0833) / 11.33);
        $license = ($totalGrossIncome * 0.0555)+($totalGrossIncome / 3 * 2 * 0.0555)/ 11.33;
        $vacationSalary = ($totalGrossIncome * 0.0555)+($totalGrossIncome / 3 *2 * 0.0555) /11.33;
        $dismissal = ($totalGrossIncome + $salary13th + $license + $vacationSalary) / 12 ;
        $provisionsTotal = $salary13th + $license + $vacationSalary + $dismissal;

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
        $accumulatedSalary13th = ($previousMonthGrossIncome * 0.0833) + (($previousMonthGrossIncome / 3 * 2 * 0.0833) / 11.33) + $salary13th;
        $accumulatedLicense = (($previousMonthGrossIncome * 0.0555)+($previousMonthGrossIncome / 3 * 2 * 0.0555)/ 11.33) + $license;
        $accumulatedVacationSalary  = (($previousMonthGrossIncome * 0.0555)+($previousMonthGrossIncome / 3 *2 * 0.0555) /11.33) + $license;
        $accumulatedDismissal = (($previousMonthGrossIncome + $salary13th + $license + $vacationSalary) / 12) +  $dismissal;
        $accumulatedProvisionsTotal = $accumulatedSalary13th + $accumulatedLicense + $accumulatedVacationSalary + $accumulatedDismissal;

        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $totalGrossIncome * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee;
        $municipalTax = 0 * $subTotal;
        $servicesTaxes = $subTotal * 0.22;
        $totalInvoice = $subTotal + $bankFee + $servicesTaxes;

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
            'socialSecurity' => $socialSecurity,
            'operationalCosts' => $operationalCosts,
            'salary13th' => $salary13th,
            'license' => $license,
            'vacationSalary' => $vacationSalary,
            'dismissal' => $dismissal,
            'previousMonthGrossIncome' => $previousMonthGrossIncome,
            'accumulatedSalary13th' => $accumulatedSalary13th,
            'accumulatedLicense' => $accumulatedLicense,
            'accumulatedVacationSalary' => $accumulatedVacationSalary,
            'accumulatedDismissal' => $accumulatedDismissal,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
        ];
    }
}
