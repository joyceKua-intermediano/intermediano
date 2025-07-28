<?php

if (!function_exists('calculateIntegralQuotation')) {
    function calculateIntegralQuotation($record, $previousRecords)
    {

        $previousVacation = 0;
        $previousIndemnization = 0;

        $previousPaidVacation = 0;
        $previousPaidIndemnization = 0;

        $grossSalary = $record->gross_salary;

        // Integral
        $totalGrossIncome =
            $record->gross_salary +
            $record->bonus +
            $record->home_allowance +
            $record->transport_allowance +
            $record->medical_allowance +
            $record->internet_allowance;

        $pensionFund = ((($totalGrossIncome - $record->home_allowance - $record->transport_allowance - $record->medical_allowance - $record->internet_allowance) * 0.70)) * 0.12;
        $healthFund = (($totalGrossIncome - $record->home_allowance - $record->transport_allowance - $record->medical_allowance - $record->internet_allowance) * 0.70) * 0.085;
        $icbfContribution = ($totalGrossIncome - $record->home_allowance - $record->transport_allowance - $record->medical_allowance - $record->internet_allowance) * 0.03;

        $senaContribution = ($totalGrossIncome - $record->home_allowance - $record->transport_allowance - $record->medical_allowance - $record->internet_allowance) * 0.02;
        $arlContribution = (($totalGrossIncome - $record->home_allowance - $record->transport_allowance - $record->medical_allowance - $record->internet_allowance) * 0.70) * 0.0244;
        $compensationFundContribution = ($totalGrossIncome - $record->home_allowance - $record->transport_allowance - $record->medical_allowance - $record->internet_allowance) * 0.04;

        $payrollCostsTotal =
            $pensionFund +
            $healthFund +
            $icbfContribution +
            $senaContribution +
            $arlContribution +
            $compensationFundContribution;

        $vacation = 0.0417 * ($record->gross_salary + $record->bonus);
        $indemnization = 0.056 * ($record->gross_salary + $record->bonus);
        $provisionsTotal = $vacation + $indemnization;
        // accumulated provision
        if ($previousRecords && $previousRecords->count()) {
            foreach ($previousRecords as $item) {
                $gross = $item->gross_salary +
                    $item->bonus +
                    $item->home_allowance +
                    $item->transport_allowance +
                    $item->medical_allowance +
                    $item->internet_allowance;

                $previousVacation += 0.0417 * $gross;
                $previousIndemnization += 0.056 * $gross;


                // Payments
                $previousPaidVacation += $item->paymentProvisions->where('provisionType.name', 'Vacation')->sum('amount');
                $previousPaidIndemnization += $item->paymentProvisions->where('provisionType.name', 'Indemnization')->sum('amount');

            }
        }

        $accumulatedIndemnization = ($previousIndemnization + $indemnization) - $previousPaidIndemnization;
        $accumulatedVacation = ($previousVacation + $vacation) - $previousPaidVacation;
        $accumulatedProvisionsTotal = $accumulatedVacation + $accumulatedIndemnization;

        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee + $bankFee;
        $municipalTax = 0.01 * $subTotal;
        $servicesTaxes = ($municipalTax + $subTotal) * 0.19;
        $totalInvoice = $subTotal + $municipalTax + $servicesTaxes;

        // current payment

        $currentPaidVacation = $record->paymentProvisions
            ->where('provisionType.name', 'Vacation')
            ->sum('amount');

        $currentPaidIndemnization = $record->paymentProvisions
            ->where('provisionType.name', 'Indemnization')
            ->sum('amount');


        // All-time payments
        $totalPaidVacation = $previousPaidVacation + $currentPaidVacation;
        $totalPaidIndemnization = $previousPaidIndemnization + $currentPaidIndemnization;


        // accumulated
        $accumulatedVacation = ($previousVacation + $vacation) - $previousPaidVacation;
        $accumulatedUnIndemnization = ($previousIndemnization + $indemnization) - $previousPaidIndemnization;


        $accumulatedProvisionsTotal = $accumulatedUnIndemnization + $accumulatedVacation;

        // Balances
        $balanceVacation = $currentPaidVacation == 0 ? $accumulatedVacation : ($accumulatedVacation - $totalPaidVacation);
        $balanceIndemnization = $currentPaidIndemnization == 0 ? $accumulatedIndemnization : ($accumulatedIndemnization - $totalPaidIndemnization);

        $balanceProvisionsTotal = $balanceVacation + $balanceIndemnization;

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
            'pensionFund' => $pensionFund,
            'healthFund' => $healthFund,
            'icbfContribution' => $icbfContribution,
            'senaContribution' => $senaContribution,
            'arlContribution' => $arlContribution,
            'compensationFundContribution' => $compensationFundContribution,
            'vacation' => $vacation,
            'indemnization' => $indemnization,
            'hasPreviousRecords' => !empty($previousRecords),
            'accumulatedVacation' => $accumulatedVacation,
            'accumulatedIndemnization' => $accumulatedIndemnization,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
            'paymentProvisions' => $record->paymentProvisions,
            'balanceIndemnization' => $balanceIndemnization,
            'balanceVacation' => $balanceVacation,
            'balanceProvisionsTotal' => $balanceProvisionsTotal,
        ];
    }
}
