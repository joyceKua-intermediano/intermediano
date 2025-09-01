<?php

if (!function_exists('calculateDominicanRepublicQuotation')) {
    function calculateDominicanRepublicQuotation($record, $previousRecords)
    {
        $previousSalary13th = 0;
        $previousAnnualBonus = 0;
        $previousNotice = 0;
        $previousUnemployment = 0;
        $previousVacations = 0;

        $previousPaidSalary13th = 0;
        $previousPaidAnnualBonus = 0;
        $previousPaidNotice = 0;
        $previousPaidUnemployment = 0;
        $previousPaidVacations = 0;

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
        $srl = $totalGrossIncome * .01;
        $infotep = $totalGrossIncome * 0.01;
        $payrollCostsLists = ['afp', 'sfs', 'srl', 'infotep'];

        $payrollCostsTotal = $afp + $sfs + $srl + $infotep;
        $salary13th = 0.0833 * $totalGrossIncome;
        $annualBonus = 0.1250 * $totalGrossIncome;
        $notice = (($record->payrollCosts->notice ?? 0) / 100) * $totalGrossIncome;
        $unemployment = (($record->payrollCosts->unemployment ?? 0) / 100) * $totalGrossIncome;
        $vacations = 0.0490 * $totalGrossIncome;
        $provisionLists = ['salary13th', 'annualBonus', 'notice', 'unemployement', 'vacations'];

        $provisionsTotal = $salary13th + $annualBonus + $notice + $unemployment + $vacations;

        // accumulated provision
        if ($previousRecords && $previousRecords->count()) {
            foreach ($previousRecords as $item) {
                $gross = $item->gross_salary +
                    $item->bonus +
                    $item->home_allowance +
                    $item->medical_allowance +
                    $item->legal_grafication +
                    $item->internet_allowance +
                    $item->transport_allowance +
                    $item->food_allowance;
                $previousSalary13th += 0.0833 * $gross;
                $previousAnnualBonus += 0.1250 * $gross;
                $previousNotice += (($item->payrollCosts->notice ?? 0) / 100) * $gross;
                $previousUnemployment += (($item->payrollCosts->unemployment ?? 0) / 100) * $gross;
                $previousVacations += 0.0490 * $gross;
                // Payments
                $previousPaidSalary13th += $item->paymentProvisions->where('provisionType.name', '13th Salary')->sum('amount');
                $previousPaidAnnualBonus += $item->paymentProvisions->where('provisionType.name', 'Annual Bonus')->sum('amount');
                $previousPaidNotice += $item->paymentProvisions->where('provisionType.name', 'Notice period')->sum('amount');
                $previousPaidUnemployment += $item->paymentProvisions->where('provisionType.name', 'Unemployment')->sum('amount');
                $previousPaidVacations += $item->paymentProvisions->where('provisionType.name', 'Vacation')->sum('amount');

            }
        }


        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee;
        $municipalTax = 0 * $subTotal;
        $servicesTaxes = $subTotal * 0;
        $totalInvoice = $subTotal + $bankFee;

        $currentPaidSalary13th = $record->paymentProvisions
            ->where('provisionType.name', '13th Salary')
            ->sum('amount');

        $currentPaidAnnualBonus = $record->paymentProvisions
            ->where('provisionType.name', 'Annual Bonus')
            ->sum('amount');
        $currentPaidNotice = $record->paymentProvisions
            ->where('provisionType.name', 'Notice period')
            ->sum('amount');
        $currentPaidUnemployment = $record->paymentProvisions
            ->where('provisionType.name', 'Unemployment')
            ->sum('amount');
        $currentPaidVacations = $record->paymentProvisions
            ->where('provisionType.name', 'Vacation')
            ->sum('amount');
        // All-time payments

        $totalPaidSalary13th = $previousPaidSalary13th + $currentPaidSalary13th;
        $totalPaidAnnualBonus = $previousPaidAnnualBonus + $currentPaidAnnualBonus;
        $totalPaidNotice = $previousPaidNotice + $currentPaidNotice;
        $totalPaidUnemployment = $previousPaidUnemployment + $currentPaidUnemployment;
        $totalPaidVacations = $previousPaidVacations + $currentPaidVacations;

        // accumulated

        $accumulatedSalary13th = ($previousSalary13th + $salary13th) - $previousPaidSalary13th;
        $accumulatedAnnualBonus = ($previousAnnualBonus + $annualBonus) - $previousPaidAnnualBonus;
        $accumulatedNotice = ($previousNotice + $notice) - $previousPaidNotice;
        $accumulatedUnemployment = ($previousUnemployment + $unemployment) - $previousPaidUnemployment;
        $accumulatedVacations = ($previousVacations + $vacations) - $previousPaidVacations;

        $accumulatedLists = ['accumulatedSalary13th', 'accumulatedAnnualBonus', 'accumulateNotice', 'accumulateUnemployement', 'accumulatedVacations'];

        $accumulatedProvisionsTotal = $accumulatedSalary13th + $accumulatedAnnualBonus + $accumulatedNotice + $accumulatedUnemployment + $accumulatedVacations;

        // Balances

        $balanceSalary13th = $accumulatedSalary13th - $currentPaidSalary13th;
        $balanceAnnualBonus = $accumulatedAnnualBonus - $currentPaidAnnualBonus;
        $balanceNotice = $accumulatedNotice - $currentPaidNotice;
        $balanceUnemployment = $accumulatedUnemployment - $currentPaidUnemployment;
        $balanceVacations = $accumulatedVacations - $currentPaidVacations;

        $balanceProvisionsTotal = $balanceSalary13th + $balanceVacations + $balanceAnnualBonus + $balanceUnemployment + $balanceNotice;




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
            'unemployement' => $unemployment,
            'vacations' => $vacations,
            'provisionLists' => $provisionLists,
            'provisionsTotal' => $provisionsTotal,
            'hasPreviousRecords' => !empty($previousRecords),
            'accumulatedSalary13th' => $accumulatedSalary13th,
            'accumulatedAnnualBonus' => $accumulatedAnnualBonus,
            'accumulateNotice' => $accumulatedNotice,
            'accumulateUnemployement' => $accumulatedUnemployment,
            'accumulatedVacations' => $accumulatedVacations,
            'accumulatedLists' => $accumulatedLists,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
            'paymentProvisions' => $record->paymentProvisions,
            'balanceSalary13th' => $balanceSalary13th,
            'balanceVacations' => $balanceVacations,
            'balanceAnnualBonus' => $balanceAnnualBonus,
            'balanceNotice' => $balanceNotice,
            'balanceUnemployment' => $balanceUnemployment,
            'balanceProvisionsTotal' => $balanceProvisionsTotal,
        ];
    }
}
