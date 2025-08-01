<?php

if (!function_exists('calculatePeruQuotation')) {
    function calculatePeruQuotation($record, $previousRecords)
    {
        $previousGratification = 0;
        $previousExtraOrdinaryGratification = 0;
        $previousCts = 0;
        $previousVacation = 0;
        $previousTermination = 0;

        $previousPaidGratification = 0;
        $previousPaidExtraOrdinaryGratification = 0;
        $previousPaidCts = 0;
        $previousPaidVacation = 0;
        $previousPaidTermination = 0;

        $grossSalary = $record->gross_salary;

        // Ordinary
        $totalGrossIncome =
            $record->gross_salary +
            $record->bonus +
            $record->home_allowance +
            $record->transport_allowance +
            $record->family_allowance +
            $record->medical_allowance +
            $record->legal_grafication +
            $record->internet_allowance;
        $healthInsurance = ($totalGrossIncome - $record->medical_allowance) * 0.09;
        $healthInsuranceVacation = ($totalGrossIncome - $record->medical_allowance) * .0075;
        $eps = $record->payrollCosts->eps;
        $seguroVida = ($totalGrossIncome - $record->medical_allowance) * .003252;

        $payrollCostsTotal =
            $healthInsurance +
            $healthInsuranceVacation +
            $eps +
            $seguroVida;

        $gratification = 0.1667 * $totalGrossIncome;
        $extraOrdinaryGratification = .0150 * $totalGrossIncome;
        $vacation = .0973 * $totalGrossIncome;
        $cts = .0973 * $totalGrossIncome;
        $termination = .1250 * $totalGrossIncome;

        $provisionsTotal = $gratification + $extraOrdinaryGratification + $vacation + $cts + $termination;

        // accumulated provision
        if ($previousRecords && $previousRecords->count()) {
            foreach ($previousRecords as $item) {
                $gross = $item->gross_salary +
                    $item->bonus +
                    $record->family_allowance +
                    $item->home_allowance +
                    $item->transport_allowance +
                    $item->medical_allowance +
                    $item->internet_allowance;

                $previousGratification += 0.1667 * $gross;
                $previousExtraOrdinaryGratification += 0.0150 * $gross;
                $previousCts += 0.0973 * $gross;
                $previousVacation += 0.0973 * $gross;
                $previousTermination += 0.1250 * $gross;


                // Payments
                $previousPaidGratification += $item->paymentProvisions->where('provisionType.name', 'Gratification')->sum('amount');
                $previousPaidExtraOrdinaryGratification += $item->paymentProvisions->where('provisionType.name', 'Extraordinary Gratification')->sum('amount');
                $previousPaidCts += $item->paymentProvisions->where('provisionType.name', 'CTS')->sum('amount');
                $previousPaidVacation += $item->paymentProvisions->where('provisionType.name', 'Vacation')->sum('amount');
                $previousPaidTermination += $item->paymentProvisions->where('provisionType.name', 'Termination - Indemnification')->sum('amount');

            }
        }


        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee + $bankFee;
        $municipalTax = 0 * $subTotal;
        $servicesTaxes = $subTotal * 0.18;
        $totalInvoice = $subTotal + $municipalTax + $servicesTaxes;

        // current payment

        $currentPaidGratification = $record->paymentProvisions
            ->where('provisionType.name', 'Gratification')
            ->sum('amount');

        $currentPaidCts = $record->paymentProvisions
            ->where('provisionType.name', 'CTS')
            ->sum('amount');


        $currentPaidExtraOrdinaryGratification = $record->paymentProvisions
            ->where('provisionType.name', 'Extraordinary Gratification')
            ->sum('amount');

        $currentPaidTermination = $record->paymentProvisions
            ->where('provisionType.name', 'Termination - Indemnification')
            ->sum('amount');


        $currentPaidVacation = $record->paymentProvisions
            ->where('provisionType.name', 'Vacation')
            ->sum('amount');

        // All-time payments
        $totalPaidGratification = $previousPaidGratification + $currentPaidGratification;
        $totalPaidCts = $previousPaidCts + $currentPaidCts;
        $totalPaidExtraOrdinaryGratification = $previousPaidExtraOrdinaryGratification + $currentPaidExtraOrdinaryGratification;
        $totalPaidTermination = $previousPaidTermination + $currentPaidTermination;
        $totalPaidVacation = $previousPaidVacation + $currentPaidVacation;

        // accumulated
        $accumulatedGratification = ($previousGratification + $gratification) - $previousPaidGratification;
        $accumulatedCts = ($previousCts + $cts) - $previousPaidCts;
        $accumulatedExtraOrdinaryGratification = ($previousExtraOrdinaryGratification + $extraOrdinaryGratification) - $previousPaidExtraOrdinaryGratification;
        $accumulatedTermination = ($previousTermination + $termination) - $previousPaidTermination;
        $accumulatedVacation = ($previousVacation + $vacation) - $previousPaidVacation;


        $accumulatedProvisionsTotal = $accumulatedGratification + $accumulatedVacation + $accumulatedCts + $accumulatedTermination + $accumulatedExtraOrdinaryGratification;

        // Balances
        $balanceGratification = $accumulatedGratification - $currentPaidGratification;
        $balanceCts = $accumulatedCts - $currentPaidCts;
        $balanceExtraOrdinaryGratification = $accumulatedExtraOrdinaryGratification - $currentPaidExtraOrdinaryGratification;
        $balanceTermination = $accumulatedTermination - $currentPaidTermination;
        $balanceVacation = $accumulatedVacation - $currentPaidVacation;

        $balanceProvisionsTotal = $balanceVacation + $balanceGratification + $balanceCts + $balanceExtraOrdinaryGratification + $balanceTermination;

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
            'healthInsurance' => $healthInsurance,
            'healthInsuranceVacation' => $healthInsuranceVacation,
            'eps' => $eps,
            'seguroVida' => $seguroVida,
            'gratification' => $gratification,
            'extraOrdinaryGratification' => $extraOrdinaryGratification,
            'vacation' => $vacation,
            'cts' => $cts,
            'termination' => $termination,
            'hasPreviousRecords' => !empty($previousRecords),
            'accumulatedGratification' => $accumulatedGratification,
            'accumulatedExtraOrdinaryGratification' => $accumulatedExtraOrdinaryGratification,
            'accumulatedVacation' => $accumulatedVacation,
            'accumulatedCts' => $accumulatedCts,
            'accumulatedTermination' => $accumulatedTermination,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,

            'paymentProvisions' => $record->paymentProvisions,
            'balanceGratification' => $balanceGratification,
            'balanceCts' => $balanceCts,
            'balanceExtraOrdinaryGratification' => $balanceExtraOrdinaryGratification,
            'balanceTermination' => $balanceTermination,
            'balanceVacation' => $balanceVacation,
            'balanceProvisionsTotal' => $balanceProvisionsTotal,
        ];
    }
}
