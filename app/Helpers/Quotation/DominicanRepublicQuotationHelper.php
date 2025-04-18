<?php

if (!function_exists('calculateDominicanRepublicQuotation')) {
    function calculateDominicanRepublicQuotation($record, $previousMonthRecord)
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

        $afp = $totalGrossIncome * 0.0710;
        $sfs = $totalGrossIncome * 0.0709;
        $srl = $totalGrossIncome * 0.01;
        $infotep = $totalGrossIncome * 0.01;
        $payrollCostsLists = ['afp', 'sfs', 'srl', 'infotep'];

        $payrollCostsTotal = $afp + $sfs + $srl + $infotep;
        $salary13th = 0.0833 * $totalGrossIncome;
        $annualBonus = 0.1250 * $totalGrossIncome;
        $notice =($record->payrollCosts->notice ?? 0 / 100) * $totalGrossIncome;
        $unemployement = ($record->payrollCosts->unemployment ?? 0 / 100) * $totalGrossIncome;
        $vacations = 0.0490 * $totalGrossIncome;
        $provisionLists = ['salary13th', 'annualBonus', 'notice', 'unemployement', 'vacations'];

        $provisionsTotal = $salary13th + $annualBonus + $notice + $unemployement + $vacations;

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

        $accumulatedSalary13th = (0.0833 * $previousMonthGrossIncome) + $salary13th;
        $accumulatedAnnualBonus = (0.1250 * $previousMonthGrossIncome) + $annualBonus;
        $accumulateNotice = (0.0770 * $previousMonthGrossIncome) + $notice;
        $accumulateUnemployement = (0.0734 * $previousMonthGrossIncome) + $unemployement;
        $accumulatedVacations = (0.0490 * $previousMonthGrossIncome) + $vacations;
        $accumulatedLists = ['accumulatedSalary13th', 'accumulatedAnnualBonus', 'accumulateNotice', 'accumulateUnemployement', 'accumulatedVacations'];

        $accumulatedProvisionsTotal = $accumulatedSalary13th + $accumulatedAnnualBonus + $accumulateNotice + $accumulateUnemployement + $accumulatedVacations;
        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee;
        $municipalTax = 0 * $subTotal;
        $servicesTaxes = $subTotal * 0;
        $totalInvoice = $subTotal + $bankFee;

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
            'afp' => $afp,
            'sfs' => $sfs,
            'srl' => $srl,
            'infotep' => $infotep,
            'payrollCostsLists' => $payrollCostsLists,
            'payrollCostsTotal' => $payrollCostsTotal,
            'salary13th' => $salary13th,
            'annualBonus' => $annualBonus,
            'notice' => $notice,
            'unemployement' => $unemployement,
            'vacations' => $vacations,
            'provisionLists' => $provisionLists,
            'provisionsTotal' => $provisionsTotal,
            'previousMonthGrossIncome' => $previousMonthGrossIncome,
            'accumulatedSalary13th' => $accumulatedSalary13th,
            'accumulatedAnnualBonus' => $accumulatedAnnualBonus,
            'accumulateNotice' => $accumulateNotice,
            'accumulateUnemployement' => $accumulateUnemployement,
            'accumulatedVacations' => $accumulatedVacations,
            'accumulatedLists' => $accumulatedLists,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
        ];
    }
}
