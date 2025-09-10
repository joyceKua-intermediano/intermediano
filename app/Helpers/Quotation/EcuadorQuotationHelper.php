<?php

if (!function_exists('calculateEcuadorQuotation')) {
    function calculateEcuadorQuotation($record, $previousRecords)
    {

        $previousVacation = 0;
        $previousCompensation = 0;
        $previousReserveFund = 0;
        $previousBonus13th = 0;
        $previousBonus14th = 0;
        $previousBonification = 0;

        $previousPaidVacation = 0;
        $previousPaidCompensation = 0;
        $previousPaidReserveFund = 0;
        $previousPaidBonus13th = 0;
        $previousPaidBonus14th = 0;
        $previousPaidBonification = 0;

        $grossSalary = $record->gross_salary;

        // Ordinary
        $totalGrossIncome =
            $record->gross_salary +
            $record->bonus +
            $record->home_allowance +
            $record->transport_allowance +
            $record->medical_allowance +
            $record->internet_allowance;

        $iess = $totalGrossIncome * 0.1115;
        $secap = $totalGrossIncome * 0.005;
        $iece = $totalGrossIncome * 0.005;
        $payrollCostsTotal =
            $iess +
            $secap +
            $iece;

        $vacation = 0.0417 * $totalGrossIncome;
        $reserveFund = 0.08333 * $totalGrossIncome;
        $bonus13th = 0.08333 * $totalGrossIncome;
        $bonus14th = 0.08333 * 470;
        $bonification = .0208 * $totalGrossIncome;
        $compensation = 0.25 * $totalGrossIncome;
        $provisionsTotal = $vacation + $reserveFund + $bonus13th + $bonus14th + $bonification + $compensation;

        if ($previousRecords && $previousRecords->count()) {
            foreach ($previousRecords as $item) {
                $gross = $item->gross_salary +
                    $item->bonus +
                    $item->home_allowance +
                    $item->transport_allowance +
                    $item->medical_allowance +
                    $item->internet_allowance;

                $previousVacation += 0.0417 * $gross;
                $previousCompensation += 0.25 * $gross;
                $previousReserveFund += 0.08333 * $gross;
                $previousBonus13th += 0.08333 * $gross;
                $previousBonus14th += 0.08333 * 470;
                $previousBonification += 0.0208 * $gross;


                // Payments
                $previousPaidVacation += $item->paymentProvisions->where('provisionType.name', 'Vacation')->sum('amount');
                $previousPaidCompensation += $item->paymentProvisions->where('provisionType.name', 'Compensation')->sum('amount');
                $previousPaidReserveFund += $item->paymentProvisions->where('provisionType.name', 'Reserve Fund')->sum('amount');
                $previousPaidBonus13th += $item->paymentProvisions->where('provisionType.name', 'Bonus 13th')->sum('amount');
                $previousPaidBonus14th += $item->paymentProvisions->where('provisionType.name', 'Bonus 14th')->sum('amount');
                $previousPaidBonification += $item->paymentProvisions->where('provisionType.name', '25% Bonification')->sum('amount');

            }
        }

        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100);
        $bankFee = $record->bank_fee;
        $subTotal = $subTotalGrossPayroll + $fee + $bankFee;
        $municipalTax = 0 * $subTotal;
        $servicesTaxes = ($municipalTax + $subTotal) * 0;
        $totalInvoice = $subTotal + $municipalTax + $servicesTaxes;

        // current payment

        $currentPaidVacation = $record->paymentProvisions
            ->where('provisionType.name', 'Vacation')
            ->sum('amount');

        $currentPaidCompensation = $record->paymentProvisions
            ->where('provisionType.name', 'Compensation')
            ->sum('amount');

        $currentPaidReserveFund = $record->paymentProvisions
            ->where('provisionType.name', 'Reserve Fund')
            ->sum('amount');

        $currentPaidBonus13th = $record->paymentProvisions
            ->where('provisionType.name', 'Bonus 13th')
            ->sum('amount');

        $currentPaidBonus14th = $record->paymentProvisions
            ->where('provisionType.name', 'Bonus 14th')
            ->sum('amount');

        $currentPaidBonification = $record->paymentProvisions
            ->where('provisionType.name', '25% Bonification')
            ->sum('amount');

        // All-time payments

        $totalPaidVacation = $previousPaidVacation + $currentPaidVacation;
        $totalPaidCompensation = $previousPaidCompensation + $currentPaidCompensation;
        $totalPaidReserveFund = $previousPaidReserveFund + $currentPaidReserveFund;
        $totalPaidBonus13th = $previousPaidBonus13th + $currentPaidBonus13th;
        $totalPaidBonus14th = $previousPaidBonus14th + $currentPaidBonus14th;
        $totalPaidBonification = $previousPaidBonification + $currentPaidBonification;

        // accumulated

        $accumulatedVacation = ($previousVacation + $vacation) - $previousPaidVacation;
        $accumulatedCompensation = ($previousCompensation + $compensation) - $previousPaidCompensation;
        $accumulatedReserveFund = ($previousReserveFund + $reserveFund) - $previousPaidReserveFund;
        $accumulatedBonus13th = ($previousBonus13th + $bonus13th) - $previousPaidBonus13th;
        $accumulatedBonus14th = ($previousBonus14th + $bonus14th) - $previousPaidBonus14th;
        $accumulatedBonification = ($previousBonification + $bonification) - $previousPaidBonification;

        $accumulatedProvisionsTotal = $accumulatedReserveFund + $accumulatedVacation + $accumulatedCompensation + $accumulatedBonus13th + $accumulatedBonus14th + $accumulatedBonification;

        // Balances

        $balanceVacation = $accumulatedVacation - $currentPaidVacation;
        $balanceCompensation = $accumulatedCompensation - $currentPaidCompensation;
        $balanceReserveFund = $accumulatedReserveFund - $currentPaidReserveFund;
        $balanceBonus13th = $accumulatedBonus13th - $currentPaidBonus13th;
        $balanceBonus14th = $accumulatedBonus14th - $currentPaidBonus14th;
        $balanceBonification = $accumulatedBonification - $currentPaidBonification;

        $balanceProvisionsTotal = $balanceVacation + $balanceCompensation + $balanceReserveFund + $balanceBonus13th + $balanceBonus14th + $balanceBonification;

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
            'iess' => $iess,
            'secap' => $secap,
            'iece' => $iece,
            'vacation' => $vacation,
            'reserveFund' => $reserveFund,
            'bonus13th' => $bonus13th,
            'bonus14th' => $bonus14th,
            'bonification' => $bonification,
            'compensation' => $compensation,
            'hasPreviousRecords' => !empty($previousRecords),
            'accumulatedVacation' => $accumulatedVacation,
            'accumulatedReserveFund' => $accumulatedReserveFund,
            'accumulatedBonus13th' => $accumulatedBonus13th,
            'accumulatedBonus14th' => $accumulatedBonus14th,
            'accumulatedBonification' => $accumulatedBonification,
            'accumulatedCompensation' => $accumulatedCompensation,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,

            'paymentProvisions' => $record->paymentProvisions,
            'balanceVacation' => $balanceVacation,
            'balanceCompensation' => $balanceCompensation,
            'balanceReserveFund' => $balanceReserveFund,
            'balanceBonus13th' => $balanceBonus13th,
            'balanceBonus14th' => $balanceBonus14th,
            'balanceBonification' => $balanceBonification,
            'balanceProvisionsTotal' => $balanceProvisionsTotal,
        ];
    }
}
