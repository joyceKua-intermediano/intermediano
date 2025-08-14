<?php

if (!function_exists('calculatePanamaQuotation')) {
    function calculatePanamaQuotation($record, $previousRecords)
    {

        $previousChristmasBonus = 0;
        $previousVacations = 0;
        $previousForewarning = 0;
        $previousSeverance = 0;
        $previousSeniority = 0;

        $previousPaidChristmasBonus = 0;
        $previousPaidVacations = 0;
        $previousPaidForewarning = 0;
        $previousPaidSeverance = 0;
        $previousPaidSeniority = 0;

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

        $css = $totalGrossIncome * 0.1225;
        $professionalRisk = $totalGrossIncome * 0.021;
        $educationalInsurance = $totalGrossIncome * 0.0150;

        $payrollCostsTotal = $css + $professionalRisk + $educationalInsurance;

        $christmasBonus = 0.1007 * $totalGrossIncome;
        $vacations = 0.1053 * $totalGrossIncome;
        $forewarning = 0.0909 * $totalGrossIncome;
        $severance = 0.0713 * $totalGrossIncome;
        $seniority = 0.0210 * $totalGrossIncome;
        $provisionsTotal = $christmasBonus + $vacations + $forewarning + $severance + $seniority;

        // accumulated provision
        if ($previousRecords && $previousRecords->count()) {
            foreach ($previousRecords as $item) {
                $gross = $item->gross_salary +
                    $item->bonus +
                    $item->transport_allowance +
                    $item->food_allowance;

                $previousChristmasBonus += 0.1007 * $gross;
                $previousVacations += 0.1053 * $gross;
                $previousForewarning += 0.0909 * $gross;
                $previousSeverance += 0.0713 * $gross;
                $previousSeniority += 0.0210 * $gross;
                // Payments
                $previousPaidChristmasBonus += $item->paymentProvisions->where('provisionType.name', 'Christmas bonus')->sum('amount');
                $previousPaidVacations += $item->paymentProvisions->where('provisionType.name', 'Vacation')->sum('amount');
                $previousPaidForewarning += $item->paymentProvisions->where('provisionType.name', 'Forewarning')->sum('amount');
                $previousPaidSeverance += $item->paymentProvisions->where('provisionType.name', 'Severance')->sum('amount');
                $previousPaidSeniority += $item->paymentProvisions->where('provisionType.name', 'Seniority')->sum('amount');
            }
        }


        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee;
        $municipalTax = 0 * $subTotal;
        $totalPartial = $subTotal + $bankFee;

        $servicesTaxes = $totalPartial * 0.07;
        $totalInvoice = $totalPartial + $servicesTaxes;


        $currentPaidChristmasBonus = $record->paymentProvisions
            ->where('provisionType.name', 'Christmas bonus')
            ->sum('amount');
        $currentPaidVacations = $record->paymentProvisions
            ->where('provisionType.name', 'Vacation')
            ->sum('amount');
        $currentPaidForewarning = $record->paymentProvisions
            ->where('provisionType.name', 'Forewarning')
            ->sum('amount');
        $currentPaidSeverance = $record->paymentProvisions
            ->where('provisionType.name', 'Severance')
            ->sum('amount');
        $currentPaidSeniority = $record->paymentProvisions
            ->where('provisionType.name', 'Seniority')
            ->sum('amount');

        // All-time payments

        $totalPaidChristmasBonus = $previousPaidChristmasBonus + $currentPaidChristmasBonus;
        $totalPaidVacations = $previousPaidVacations + $currentPaidVacations;
        $totalPaidForewarning = $previousPaidForewarning + $currentPaidForewarning;
        $totalPaidSeverance = $previousPaidSeverance + $currentPaidSeverance;
        $totalPaidSeniority = $previousPaidSeniority + $currentPaidSeniority;
        // accumulated

        $accumulatedChristmasBonus = ($previousChristmasBonus + $christmasBonus) - $previousPaidChristmasBonus;
        $accumulatedVacations = ($previousVacations + $vacations) - $previousPaidVacations;
        $accumulatedForewarning = ($previousForewarning + $forewarning) - $previousPaidForewarning;
        $accumulatedSeverance = ($previousSeverance + $severance) - $previousPaidSeverance;
        $accumulatedSeniority = ($previousSeniority + $seniority) - $previousPaidSeniority;

        $accumulatedProvisionsTotal = $accumulatedChristmasBonus + $accumulatedVacations + $accumulatedForewarning + $accumulatedSeverance + $accumulatedSeniority;

        // Balances

        $balanceChristmasBonus = $accumulatedChristmasBonus - $currentPaidChristmasBonus;
        $balanceVacations = $accumulatedVacations - $currentPaidVacations;
        $balanceForewarning = $accumulatedForewarning - $currentPaidForewarning;
        $balanceSeverance = $accumulatedSeverance - $currentPaidSeverance;
        $balanceSeniority = $accumulatedSeniority - $currentPaidSeniority;

        $balanceProvisionsTotal = $balanceChristmasBonus + $balanceVacations + $balanceForewarning + $balanceSeverance + $balanceSeniority;

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
            'totalPartial' => $totalPartial,
            'totalInvoice' => $totalInvoice,
            'css' => $css,
            'professionalRisk' => $professionalRisk,
            'educationalInsurance' => $educationalInsurance,
            'christmasBonus' => $christmasBonus,
            'vacations' => $vacations,
            'forewarning' => $forewarning,
            'severance' => $severance,
            'seniority' => $seniority,
            'hasPreviousRecords' => !empty($previousRecords),
            'accumulatedChristmasBonus' => $accumulatedChristmasBonus,
            'accumulatedVacations' => $accumulatedVacations,
            'accumulatedForewarning' => $accumulatedForewarning,
            'accumulatedSeverance' => $accumulatedSeverance,
            'accumulatedSeniority' => $accumulatedSeniority,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
            'paymentProvisions' => $record->paymentProvisions,
            'balanceChristmasBonus' => $balanceChristmasBonus,
            'balanceVacations' => $balanceVacations,
            'balanceForewarning' => $balanceForewarning,
            'balanceSeverance' => $balanceSeverance,
            'balanceSeniority' => $balanceSeniority,
            'balanceProvisionsTotal' => $balanceProvisionsTotal,
        ];
    }
}
