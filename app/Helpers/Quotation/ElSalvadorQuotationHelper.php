<?php

if (!function_exists('calculateElSalvadorQuotation')) {
    function calculateElSalvadorQuotation($record, $previousRecords)
    {
        $previousVacations = 0;
        $previousCompensation = 0;
        $previousChristmasBonus = 0;

        $previousPaidVacations = 0;
        $previousPaidCompensation = 0;
        $previousPaidChristmasBonus = 0;

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

        $iss = $totalGrossIncome * 0.075;
        $insaforp = $totalGrossIncome * 0.01;
        $afp = $totalGrossIncome * 0.0775;

        $payrollCostsTotal = $iss + $insaforp + $afp;

        $compensation = 0.0417 * $totalGrossIncome;
        $vacations = 0.0417 * $totalGrossIncome;
        $christmasBonus = 0.0833 * $totalGrossIncome;
        $provisionsTotal = $compensation + $vacations + $christmasBonus;

        // accumulated provision
        if ($previousRecords && $previousRecords->count()) {
            foreach ($previousRecords as $item) {
                $gross = $item->gross_salary +
                    $item->bonus +
                    $item->transport_allowance +
                    $item->food_allowance;

                $previousChristmasBonus += 0.0833 * $gross;
                $previousVacations += 0.0417 * $gross;
                $previousCompensation += 0.0417 * $gross;

                // Payments
                $previousPaidChristmasBonus += $item->paymentProvisions->where('provisionType.name', 'Christmas bonus')->sum('amount');
                $previousPaidVacations += $item->paymentProvisions->where('provisionType.name', 'Vacation')->sum('amount');
                $previousPaidCompensation += $item->paymentProvisions->where('provisionType.name', 'Compensation')->sum('amount');
            }
        }

        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee + $bankFee;
        $servicesTaxes = $subTotal * 0.13;
        $totalInvoice = $subTotal + $servicesTaxes;

        $currentPaidChristmasBonus = $record->paymentProvisions
            ->where('provisionType.name', 'Christmas bonus')
            ->sum('amount');
        $currentPaidVacations = $record->paymentProvisions
            ->where('provisionType.name', 'Vacation')
            ->sum('amount');
        $currentPaidCompensation = $record->paymentProvisions
            ->where('provisionType.name', 'Compensation')
            ->sum('amount');
        // All-time payments

        $totalPaidChristmasBonus = $previousPaidChristmasBonus + $currentPaidChristmasBonus;
        $totalPaidVacations = $previousPaidVacations + $currentPaidVacations;
        $totalPaidCompensation = $previousPaidCompensation + $currentPaidCompensation;

        // accumulated

        $accumulatedChristmasBonus = ($previousChristmasBonus + $christmasBonus) - $previousPaidChristmasBonus;
        $accumulatedVacations = ($previousVacations + $vacations) - $previousPaidVacations;
        $accumulatedCompensation = ($previousCompensation + $compensation) - $previousPaidCompensation;


        $accumulatedProvisionsTotal = $accumulatedChristmasBonus + $accumulatedVacations + $accumulatedCompensation;

        // Balances

        $balanceChristmasBonus = $accumulatedChristmasBonus - $currentPaidChristmasBonus;
        $balanceVacations = $accumulatedVacations - $currentPaidVacations;
        $balanceCompensation = $accumulatedCompensation - $currentPaidCompensation;

        $balanceProvisionsTotal = $balanceChristmasBonus + $balanceVacations + $balanceCompensation;

        return [
            'grossSalary' => $grossSalary,
            'totalGrossIncome' => $totalGrossIncome,
            'payrollCostsTotal' => $payrollCostsTotal,
            'provisionsTotal' => $provisionsTotal,
            'subTotalGrossPayroll' => $subTotalGrossPayroll,
            'fee' => $fee,
            'bankFee' => $bankFee,
            'subTotal' => $subTotal,
            'servicesTaxes' => $servicesTaxes,
            'totalInvoice' => $totalInvoice,
            'iss' => $iss,
            'insaforp' => $insaforp,
            'afp' => $afp,
            'compensation' => $compensation,
            'christmasBonus' => $christmasBonus,
            'vacations' => $vacations,
            'hasPreviousRecords' => !empty($previousRecords),

            'accumulatedCompensation' => $accumulatedCompensation,
            'accumulatedChristmasBonus' => $accumulatedChristmasBonus,
            'accumulatedVacations' => $accumulatedVacations,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
            'paymentProvisions' => $record->paymentProvisions,
            'balanceChristmasBonus' => $balanceChristmasBonus,
            'balanceVacations' => $balanceVacations,
            'balanceCompensation' => $balanceCompensation,
            'balanceProvisionsTotal' => $balanceProvisionsTotal,
        ];
    }
}
