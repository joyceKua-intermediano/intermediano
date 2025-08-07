<?php

if (!function_exists('calculateUruguayQuotation')) {
    function calculateUruguayQuotation($record, $previousRecords)
    {
        $previousSalary13th = 0;
        $previousLicense = 0;
        $previousVacationSalary = 0;
        $previousDismissal = 0;

        $previousPaidSalary13th = 0;
        $previousPaidLicense = 0;
        $previousPaidVacationSalary = 0;
        $previousPaidDismissal = 0;

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
        $license = ($totalGrossIncome * 0.0555) + ($totalGrossIncome / 3 * 2 * 0.0555) / 11.33;
        $vacationSalary = ($totalGrossIncome * 0.0555) + ($totalGrossIncome / 3 * 2 * 0.0555) / 11.33;
        $dismissal = ($totalGrossIncome + $salary13th + $license + $vacationSalary) / 12;
        $provisionsTotal = $salary13th + $license + $vacationSalary + $dismissal;

        // accumulated provision
        if ($previousRecords && $previousRecords->count()) {
            foreach ($previousRecords as $item) {
                $gross = $item->gross_salary +
                    $item->bonus +
                    $item->home_allowance +
                    $item->transport_allowance +
                    $item->medical_allowance +
                    $item->internet_allowance;

                $previousSalary13th += ($gross * 0.0833) + (($gross / 3 * 2 * 0.0833) / 11.33);
                $previousLicense += ($gross * 0.0555) + ($gross / 3 * 2 * 0.0555) / 11.33;
                $previousVacationSalary += ($gross * 0.0555) + ($gross / 3 * 2 * 0.0555) / 11.33;
                $previousDismissal += ($totalGrossIncome + $salary13th + $license + $vacationSalary) / 12;


                // Payments
                $previousPaidSalary13th += $item->paymentProvisions->where('provisionType.name', '13th Salary')->sum('amount');
                $previousPaidLicense += $item->paymentProvisions->where('provisionType.name', 'License')->sum('amount');
                $previousPaidVacationSalary += $item->paymentProvisions->where('provisionType.name', 'Vacational Salary')->sum('amount');
                $previousPaidDismissal += $item->paymentProvisions->where('provisionType.name', 'Dismissal')->sum('amount');

            }
        }

        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $totalGrossIncome * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee;
        $municipalTax = 0 * $subTotal;
        $servicesTaxes = $subTotal * 0.22;
        $totalInvoice = $subTotal + $bankFee + $servicesTaxes;


        // current payment

        $currentPaidSalary13th = $record->paymentProvisions
            ->where('provisionType.name', '13th Salary')
            ->sum('amount');

        $currentPaidLicense = $record->paymentProvisions
            ->where('provisionType.name', 'License')
            ->sum('amount');
        $currentPaidVacationSalary = $record->paymentProvisions
            ->where('provisionType.name', 'Vacational Salary')
            ->sum('amount');
        $currentPaidDismissal = $record->paymentProvisions
            ->where('provisionType.name', 'Dismissal')
            ->sum('amount');


        // All-time payments
        $totalPaidSalary13th = $previousPaidSalary13th + $currentPaidSalary13th;
        $totalPaidLicense = $previousPaidLicense + $currentPaidLicense;
        $totalPaidVacationSalary = $previousPaidVacationSalary + $currentPaidVacationSalary;
        $totalPaidDismissal = $previousPaidDismissal + $currentPaidDismissal;

        // accumulated
        $accumulatedSalary13th = ($previousSalary13th + $salary13th) - $previousPaidSalary13th;
        $accumulatedLicense = ($previousLicense + $license) - $previousPaidLicense;
        $accumulatedVacationSalary = ($previousVacationSalary + $vacationSalary) - $previousPaidVacationSalary;
        $accumulatedDismissal = ($previousDismissal + $dismissal) - $previousPaidDismissal;


        $accumulatedProvisionsTotal = $accumulatedSalary13th + $accumulatedLicense + $accumulatedVacationSalary + $accumulatedDismissal;

        // Balances
        $balanceSalary13th = $accumulatedSalary13th - $currentPaidSalary13th;
        $balanceLicense = $accumulatedLicense - $currentPaidLicense;
        $balanceVacationSalary = $accumulatedVacationSalary - $currentPaidVacationSalary;
        $balanceDismissal = $accumulatedDismissal - $currentPaidDismissal;

        $balanceProvisionsTotal = $balanceSalary13th + $balanceLicense + $balanceVacationSalary + $balanceDismissal;

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
            'hasPreviousRecords' => !empty($previousRecords),
            'accumulatedSalary13th' => $accumulatedSalary13th,
            'accumulatedLicense' => $accumulatedLicense,
            'accumulatedVacationSalary' => $accumulatedVacationSalary,
            'accumulatedDismissal' => $accumulatedDismissal,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,

            'paymentProvisions' => $record->paymentProvisions,
            'balanceSalary13th' => $balanceSalary13th,
            'balanceLicense' => $balanceLicense,
            'balanceVacationSalary' => $balanceVacationSalary,
            'balanceDismissal' => $balanceDismissal,
            'balanceProvisionsTotal' => $balanceProvisionsTotal,
        ];
    }
}
