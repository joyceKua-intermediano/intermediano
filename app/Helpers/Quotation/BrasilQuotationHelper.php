<?php

if (!function_exists('calculateBrasilQuotation')) {
    function calculateBrasilQuotation($record, $previousRecords)
    {
        $previousSalary13th = 0;
        $previousVacation = 0;
        $previousVacationBonus = 0;
        $previousTermination = 0;

        $previousPaid13th = 0;
        $previousPaidVacation = 0;
        $previousPaidVacationBonus = 0;
        $previousPaidTermination = 0;

        $grossSalary = $record->gross_salary;

        // Ordinary
        $totalGrossIncome =
            $record->gross_salary +
            $record->bonus +
            $record->home_allowance +
            $record->transport_allowance +
            $record->medical_allowance +
            $record->internet_allowance;

        $inss = $totalGrossIncome * 0.2780;
        $fgts = $totalGrossIncome * 0.08;
        $fgtsFine = $totalGrossIncome * 0.04;
        $fgtsInss = $totalGrossIncome * 0.071539;
        $medicalInsurance = $record->payrollCosts->medical_insurance;
        $mealTicket = $record->payrollCosts->meal;
        $transportationTicket = $record->payrollCosts->transportation;
        $operationalCosts = $record->payrollCosts->operational_costs;

        $payrollCostsTotal =
            $inss +
            $fgts +
            $fgtsFine +
            $fgtsInss +
            $medicalInsurance +
            $mealTicket +
            $transportationTicket +
            $operationalCosts;

        $salary13th = 0.0833333 * $totalGrossIncome;
        $vacation = 0.0833333 * $totalGrossIncome;
        $vacationBonus = 0.0278 * $totalGrossIncome;
        $termination = 0.0833333 * $totalGrossIncome;
        $provisionsTotal = $salary13th + $vacation + $vacationBonus + $termination;

        // accumulated provision
        if ($previousRecords && $previousRecords->count()) {
            foreach ($previousRecords as $item) {
                $gross = $item->gross_salary +
                    $item->bonus +
                    $item->home_allowance +
                    $item->transport_allowance +
                    $item->medical_allowance +
                    $item->internet_allowance;

                $previousSalary13th += 0.0833333 * $gross;
                $previousVacation += 0.0833333 * $gross;
                $previousVacationBonus += 0.0278 * $gross;
                $previousTermination += 0.0833333 * $gross;

                // Payments
                $previousPaid13th += $item->paymentProvisions->where('provisionType.name', '13th Salary')->sum('amount');
                $previousPaidVacation += $item->paymentProvisions->where('provisionType.name', 'Vacation')->sum('amount');
                $previousPaidVacationBonus += $item->paymentProvisions->where('provisionType.name', '1/3 Vacation Bonus')->sum('amount');
                $previousPaidTermination += $item->paymentProvisions->where('provisionType.name', 'Termination')->sum('amount');
            }
        }


        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee + $bankFee;
        $municipalTax = 0 * $subTotal;
        $servicesTaxes = ($subTotalGrossPayroll + $fee) * 0.0695;
        $totalInvoice = $subTotal + $municipalTax + $servicesTaxes;

        // Get current payment
        // $currentPaid13th = $record->paymentProvisions->where('provision_type_id', 1)->sum('amount');
        // $currentPaidVacation = $record->paymentProvisions->where('provision_type_id', 2)->sum('amount');
        // $currentPaidVacationBonus = $record->paymentProvisions->where('provision_type_id', 4)->sum('amount');
        // $currentPaidTermination = $record->paymentProvisions->where('provision_type_id', 3)->sum('amount');

        $currentPaid13th = $record->paymentProvisions
            ->where('provisionType.name', '13th Salary')
            ->sum('amount');
        $currentPaidVacation = $record->paymentProvisions
            ->where('provisionType.name', 'Vacation')
            ->sum('amount');

        $currentPaidVacationBonus = $record->paymentProvisions
            ->where('provisionType.name', '1/3 Vacation Bonus')
            ->sum('amount');

        $currentPaidTermination = $record->paymentProvisions
            ->where('provisionType.name', 'Termination')
            ->sum('amount');

        // All-time payments
        $totalPaid13th = $previousPaid13th + $currentPaid13th;
        $totalPaidVacation = $previousPaidVacation + $currentPaidVacation;
        $totalPaidVacationBonus = $previousPaidVacationBonus + $currentPaidVacationBonus;
        $totalPaidTermination = $previousPaidTermination + $currentPaidTermination;

        // accumulated
        $accumulatedSalary13th = ($previousSalary13th + $salary13th) - $previousPaid13th;
        $accumulatedVacation = ($previousVacation + $vacation) - $previousPaidVacation;
        $accumulatedVacationBonus = ($previousVacationBonus + $vacationBonus) - $previousPaidVacationBonus;
        $accumulatedTermination = ($previousTermination + $termination) - $previousPaidTermination;

        $accumulatedProvisionsTotal = $accumulatedSalary13th + $accumulatedVacation + $accumulatedVacationBonus + $accumulatedTermination;

        // Balances
        $balance13th = $accumulatedSalary13th - $currentPaid13th;
        $balanceVacation = $accumulatedVacation - $currentPaidVacation;
        $balanceVacationBonus = $accumulatedVacationBonus - $currentPaidVacationBonus;
        $balanceTermination = $accumulatedTermination - $currentPaidTermination;

        $balanceProvisionsTotal = $balance13th + $balanceVacation + $balanceVacationBonus + $balanceTermination;
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
            'inss' => $inss,
            'fgts' => $fgts,
            'fgtsFine' => $fgtsFine,
            'fgtsInss' => $fgtsInss,
            'medicalInsurance' => $medicalInsurance,
            'mealTicket' => $mealTicket,
            'transportationTicket' => $transportationTicket,
            'operationalCosts'  => $operationalCosts,
            'payrollCostsTotal' => $payrollCostsTotal,
            'salary13th' => $salary13th,
            'vacation' => $vacation,
            'vacationBonus' => $vacationBonus,
            'termination' => $termination,
            'provisionsTotal' => $provisionsTotal,
            'hasPreviousRecords' => !empty($previousRecords),
            'accumulatedSalary13th' => $accumulatedSalary13th,
            'accumulatedVacation' => $accumulatedVacation,
            'accumulatedVacationBonus' => $accumulatedVacationBonus,
            'accumulatedTermination' => $accumulatedTermination,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
            'paymentProvisions' => $record->paymentProvisions,
            'balance13th' => $balance13th,
            'balanceVacation' => $balanceVacation,
            'balanceVacationBonus' => $balanceVacationBonus,
            'balanceTermination' => $balanceTermination,
            'balanceProvisionsTotal' => $balanceProvisionsTotal,
        ];
    }
}
