<?php

if (!function_exists('calculateHongkongQuotation')) {
    function calculateHongkongQuotation($record, $previousRecords)
    {
        $previousLeave = 0;

        $previousPaidLeave = 0;

        $mfpMinimumEarning = 30000;
        $grossSalary = $record->gross_salary;

        // Ordinary
        $totalGrossIncome =
            $record->gross_salary +
            $record->bonus +
            $record->home_allowance +
            $record->transport_allowance +
            $record->medical_allowance +
            $record->internet_allowance;

        $mpf = $totalGrossIncome > $mfpMinimumEarning ? 1500 : $totalGrossIncome * 0.05;
        $employerCompensationInsurance = 0;
        $payrollCostsTotal = $mpf;

        $privateHealthInsurance = 0;
        $proRated13thMonthPay = $totalGrossIncome / 12;
        $leave = $totalGrossIncome / 160;

        $provisionsTotal = $leave;

        // accumulated provision
        if ($previousRecords && $previousRecords->count()) {
            foreach ($previousRecords as $item) {
                $gross = $item->gross_salary +
                    $item->bonus +
                    $item->transport_allowance +
                    $item->food_allowance;

                $previousLeave += $gross / 160;
                // Payments
                $previousPaidLeave += $item->paymentProvisions->where('provisionType.name', 'Leave')->sum('amount');
            }
        }
        $bankFee = $record->bank_fee * $record->exchange_rate;

        $subTotalGrossPayroll = $totalGrossIncome + $payrollCostsTotal + $bankFee + $employerCompensationInsurance;

        $exchangeValue = $record->fee * $record->exchange_rate;
        $fixFee = 450 * $record->exchange_rate;
        $computedFeeByTotalGrossIncome = $subTotalGrossPayroll * ($record->fee / 100);

        if ($record->is_fix_fee) {
            $fee = $exchangeValue;
        } else {
            $fee = max($computedFeeByTotalGrossIncome, $fixFee);
        }
        $subTotal = $subTotalGrossPayroll + $fee;
        $totalInvoice = $subTotal;

        // current payment

        $currentPaidLeave = $record->paymentProvisions
            ->where('provisionType.name', 'Leave')
            ->sum('amount');

        // All-time payments

        $totalPaidLeave = $previousPaidLeave + $currentPaidLeave;
        // accumulated

        $accumulatedLeave = ($previousLeave + $leave) - $previousPaidLeave;


        $accumulatedProvisionsTotal = $accumulatedLeave;

        // Balances

        $balanceLeave = $accumulatedLeave - $currentPaidLeave;

        $balanceProvisionsTotal = $balanceLeave;
        return [
            'grossSalary' => $grossSalary,
            'totalGrossIncome' => $totalGrossIncome,
            'subTotalGrossPayroll' => $subTotalGrossPayroll,
            'fee' => $fee,
            'bankFee' => $bankFee,
            'subTotal' => $subTotal,
            'totalInvoice' => $totalInvoice,
            'mpf' => $mpf,
            'mployerCompensationInsurance' => $employerCompensationInsurance,
            'payrollCostsTotal' => $payrollCostsTotal,
            'leave' => $leave,
            'provisionsTotal' => $provisionsTotal,
            'hasPreviousRecords' => !empty($previousRecords),
            'accumulatedLeave' => $accumulatedLeave,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
            'paymentProvisions' => $record->paymentProvisions,
            'balanceLeave' => $balanceLeave,
            'balanceProvisionsTotal' => $balanceProvisionsTotal,
        ];
    }
}
