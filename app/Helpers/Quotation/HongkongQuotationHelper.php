<?php

if (!function_exists('calculateHongkongQuotation')) {
    function calculateHongkongQuotation($record, $previousMonthRecord)
    {

        $grossSalary = $record->gross_salary;

        // Ordinary
        $totalGrossIncome =
            $record->gross_salary +
            $record->bonus +
            $record->home_allowance +
            $record->transport_allowance +
            $record->medical_allowance +
            $record->internet_allowance;

        $mpf = $totalGrossIncome * 0.05;


        $payrollCostsTotal = $mpf;

        $leave = 0.0417 * $totalGrossIncome;

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
        };

        $accumulatedLeave = (0.0417 * $previousMonthGrossIncome) + $leave;

        $accumulatedProvisionsTotal = $accumulatedLeave;

        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $totalGrossIncome * ($record->fee / 100) ;
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee;
        $totalInvoice = $subTotal + $bankFee ;

        return [
            'grossSalary' => $grossSalary,
            'totalGrossIncome' => $totalGrossIncome,
            'subTotalGrossPayroll' => $subTotalGrossPayroll,
            'fee' => $fee,
            'bankFee' => $bankFee,
            'subTotal' => $subTotal,
            'totalInvoice' => $totalInvoice,
            'mpf' => $mpf,
            'payrollCostsTotal' => $payrollCostsTotal,
            'leave' => $leave,
            'provisionsTotal' => $provisionsTotal,
            'previousMonthGrossIncome' => $previousMonthGrossIncome,
            'accumulatedLeave' => $accumulatedLeave,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
        ];
    }
}
