<?php

if (!function_exists('calculateCostaRicaQuotation')) {
    function calculateCostaRicaQuotation($record, $previousRecords)
    {

        $previousUnEmployment = 0;
        $previousForewarning = 0;
        $previousBonus = 0;
        $previousVacation = 0;

        $previousPaidUnEmployment = 0;
        $previousPaidForewarning = 0;
        $previousPaidBonus = 0;
        $previousPaidVacation = 0;

        $grossSalary = $record->gross_salary;

        // Ordinary
        $totalGrossIncome =
            $record->gross_salary +
            $record->bonus +
            $record->home_allowance +
            $record->transport_allowance +
            $record->medical_allowance +
            $record->internet_allowance;

        $employerTaxes = ($totalGrossIncome - $record->medical_allowance) * 0.2667;
        $insPolicy = ($totalGrossIncome - $record->medical_allowance) * 0.0196;
        $medicalInsurance = ($totalGrossIncome - $record->medical_allowance) * $record->payrollCosts->medical_insurance / 100;

        $payrollCostsTotal =
            $employerTaxes +
            $insPolicy +
            $medicalInsurance;

        $unEmployment = 0.0533 * $totalGrossIncome;
        $forewarning = 0.0833 * $totalGrossIncome;
        $bonus = 0.0833 * $totalGrossIncome;
        $vacation = 0.0417 * $totalGrossIncome;
        $provisionsTotal = $unEmployment + $forewarning + $bonus + $vacation;

        // accumulated provision
        if ($previousRecords && $previousRecords->count()) {
            foreach ($previousRecords as $item) {
                $gross = $item->gross_salary +
                    $item->bonus +
                    $item->home_allowance +
                    $item->transport_allowance +
                    $item->medical_allowance +
                    $item->internet_allowance;

                $previousUnEmployment += 0.0533 * $gross;
                $previousForewarning += 0.0833 * $gross;
                $previousBonus += 0.0833 * $gross;
                $previousVacation += 0.0417 * $gross;

                // Payments
                $previousPaidUnEmployment += $item->paymentProvisions->where('provisionType.name', 'Unemployment')->sum('amount');
                $previousPaidForewarning += $item->paymentProvisions->where('provisionType.name', 'Forewarning')->sum('amount');
                $previousPaidBonus += $item->paymentProvisions->where('provisionType.name', 'Bonus')->sum('amount');
                $previousPaidVacation += $item->paymentProvisions->where('provisionType.name', 'Vacation')->sum('amount');
            }
        }
        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee + $bankFee;
        $municipalTax = 0 * $subTotal;
        $servicesTaxes = ($municipalTax + $subTotal) * 0.13;
        $totalInvoice = $subTotal + $municipalTax + $servicesTaxes;


        // current payment
        $currentPaidUnEmployment = $record->paymentProvisions
            ->where('provisionType.name', 'Unemployment')
            ->sum('amount');
        $currentPaidForewarning = $record->paymentProvisions
            ->where('provisionType.name', 'Forewarning')
            ->sum('amount');

        $currentPaidBonus = $record->paymentProvisions
            ->where('provisionType.name', 'Bonus')
            ->sum('amount');

        $currentPaidVacation = $record->paymentProvisions
            ->where('provisionType.name', 'Vacation')
            ->sum('amount');

        // All-time payments
        $totalPaidUnEmployment = $previousPaidUnEmployment + $currentPaidUnEmployment;
        $totalPaidForewarning = $previousPaidForewarning + $currentPaidForewarning;
        $totalPaidBonus = $previousPaidBonus + $currentPaidBonus;
        $totalPaidVacation = $previousPaidVacation + $currentPaidVacation;

        // accumulated
        $accumulatedUnEmployment = ($previousUnEmployment + $unEmployment) - $previousPaidUnEmployment;
        $accumulatedForewarning = ($previousForewarning + $forewarning) - $previousPaidForewarning;
        $accumulatedBonus = ($previousBonus + $bonus) - $previousPaidBonus;
        $accumulatedVacation = ($previousVacation + $vacation) - $previousPaidVacation;

        $accumulatedProvisionsTotal = $accumulatedUnEmployment + $accumulatedForewarning + $accumulatedBonus + $accumulatedVacation;

        // Balances
        $balanceUnEmployment = $accumulatedUnEmployment - $currentPaidUnEmployment;
        $balanceForewarning = $accumulatedForewarning - $currentPaidForewarning;
        $balanceBonus = $accumulatedBonus - $currentPaidBonus;
        $balanceVacation = $accumulatedVacation - $currentPaidVacation;

        $balanceProvisionsTotal = $balanceUnEmployment + $balanceVacation + $balanceForewarning + $balanceBonus;
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
            'employerTaxes' => $employerTaxes,
            'insPolicy' => $insPolicy,
            'medicalInsurance' => $medicalInsurance,
            'unEmployment' => $unEmployment,
            'forewarning' => $forewarning,
            'bonus' => $bonus,
            'vacation' => $vacation,
            'hasPreviousRecords' => !empty($previousRecords),
            'accumulatedUnEmployment' => $accumulatedUnEmployment,
            'accumulatedForewarning' => $accumulatedForewarning,
            'accumulatedBonus' => $accumulatedBonus,
            'accumulatedVacation' => $accumulatedVacation,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
            
            'paymentProvisions' => $record->paymentProvisions,
            'balanceUnEmployment' => $balanceUnEmployment,
            'balanceVacation' => $balanceVacation,
            'balanceForewarning' => $balanceForewarning,
            'balanceBonus' => $balanceBonus,
            'balanceProvisionsTotal' => $balanceProvisionsTotal,
        ];
    }
}
