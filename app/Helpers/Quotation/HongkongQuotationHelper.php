<?php

if (!function_exists('calculateHongkongQuotation')) {
    function calculateHongkongQuotation($record, $previousMonthRecord)
    {
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
        if ($previousMonthRecord) {
            $previousMonthGrossIncome = $previousMonthRecord->gross_salary +
                $previousMonthRecord->bonus +
                $previousMonthRecord->home_allowance +
                $previousMonthRecord->transport_allowance +
                $previousMonthRecord->medical_allowance +
                $previousMonthRecord->internet_allowance;
        } else {
            $previousMonthGrossIncome = 0;
        }
        ;

        $accumulatedLeave = (0.0417 * $previousMonthGrossIncome) + $leave;

        $accumulatedProvisionsTotal = $accumulatedLeave;

        // end of accumulated provision

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
            'previousMonthGrossIncome' => $previousMonthGrossIncome,
            'accumulatedLeave' => $accumulatedLeave,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
        ];
    }
}
