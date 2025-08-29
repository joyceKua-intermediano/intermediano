<?php

if (!function_exists('calculateQuotation')) {
    function calculateQuotation($record, $previousRecords)
    {

        $previousCesantias = 0;
        $previousInterestDeCesantias = 0;
        $previousPrima = 0;
        $previousIndemnization = 0;
        $previousVacation = 0;


        $previousPaidCesantias = 0;
        $previousPaidInterestDeCesantias = 0;
        $previousPaidPrima = 0;
        $previousPaidVacation = 0;
        $previousPaidIndemnization = 0;

        $grossSalary = $record->gross_salary;

        // Ordinary
        $totalGrossIncome =
            $record->gross_salary +
            $record->bonus +
            $record->home_allowance +
            $record->transport_allowance +
            $record->medical_allowance +
            $record->internet_allowance;
        $pensionFund = ($totalGrossIncome - $record->medical_allowance - $record->home_allowance - $record->transport_allowance - $record->internet_allowance) * 0.12;
        $healthFund = ($totalGrossIncome - $record->medical_allowance - $record->home_allowance - $record->transport_allowance - $record->internet_allowance) * 0.085;
        $icbfContribution = ($totalGrossIncome - $record->medical_allowance - $record->home_allowance - $record->transport_allowance - $record->internet_allowance) * 0.03;
        $senaContribution = ($totalGrossIncome - $record->medical_allowance - $record->home_allowance - $record->transport_allowance - $record->internet_allowance) * 0.02;
        $arlContribution = ($totalGrossIncome - $record->medical_allowance - $record->home_allowance - $record->transport_allowance - $record->internet_allowance) * 0.0244;
        $compensationFundContribution = ($totalGrossIncome - $record->medical_allowance - $record->home_allowance - $record->transport_allowance - $record->internet_allowance) * 0.04;
        $operationalCosts = $record->payrollCosts?->operational_costs;

        $payrollCostsTotal =
            $pensionFund +
            $healthFund +
            $icbfContribution +
            $senaContribution +
            $arlContribution +
            $compensationFundContribution +
            $operationalCosts;

        $cesantias = 0.0833 * $totalGrossIncome;
        $interestDeCesantias = $cesantias * 0.12;
        $prima = 0.0833 * $totalGrossIncome;
        $vacation = 0.0417 * $totalGrossIncome;
        $indemnization = 0.056 * $totalGrossIncome;
        $provisionsTotal = $cesantias + $interestDeCesantias + $prima + $vacation + $indemnization;

        // previous provision
        if ($previousRecords && $previousRecords->count()) {
            foreach ($previousRecords as $item) {
                $gross = $item->gross_salary +
                    $item->bonus +
                    $item->home_allowance +
                    $item->transport_allowance +
                    $item->medical_allowance +
                    $item->internet_allowance;
                $cesantia = 0.0833 * $gross;
                $interest = $cesantia * 0.12;

                $previousCesantias += $cesantia;
                $previousInterestDeCesantias += $interest;
                $previousPrima += 0.0833 * $gross;
                $previousVacation += 0.0417 * $gross;
                $previousIndemnization += 0.056 * $gross;


                // previous paid provisions
                $previousPaidCesantias += $item->paymentProvisions->where('provisionType.name', 'Cesantias')->sum('amount');
                $previousPaidInterestDeCesantias += $item->paymentProvisions->where('provisionType.name', 'Intereses de Cesantias')->sum('amount');
                $previousPaidPrima += $item->paymentProvisions->where('provisionType.name', 'Prima')->sum('amount');
                $previousPaidVacation += $item->paymentProvisions->where('provisionType.name', 'Vacation')->sum('amount');
                $previousPaidIndemnization += $item->paymentProvisions->where('provisionType.name', 'Indemnization')->sum('amount');

            }
        }

        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee + $bankFee;
        $municipalTax = 0.01 * $subTotal;
        $servicesTaxes = ($municipalTax + $subTotal) * 0.19;
        $totalInvoice = $subTotal + $municipalTax + $servicesTaxes;

        $currentPaidCesantias = $record->paymentProvisions
            ->where('provisionType.name', 'Cesantias')
            ->sum('amount');
        $currentPaidInterestDeCesantias = $record->paymentProvisions
            ->where('provisionType.name', 'Intereses de Cesantias')
            ->sum('amount');
        $currentPaidPrima = $record->paymentProvisions
            ->where('provisionType.name', 'Prima')
            ->sum('amount');
        $currentPaidVacation = $record->paymentProvisions
            ->where('provisionType.name', 'Vacation')
            ->sum('amount');
        $currentPaidIndemnization = $record->paymentProvisions
            ->where('provisionType.name', 'Indemnization')
            ->sum('amount');


        // All-time provisions payments
        $totalPaidCesantias = $previousPaidCesantias + $currentPaidCesantias;
        $totalPaidInterestDeCesantias = $previousPaidInterestDeCesantias + $currentPaidInterestDeCesantias;
        $totalPaidPrima = $previousPaidPrima + $currentPaidPrima;
        $totalPaidVacation = $previousPaidVacation + $currentPaidVacation;
        $totalPaidIndemnization = $previousPaidIndemnization + $currentPaidIndemnization;


        // accumulated
        $accumulatedCesantias = ($previousCesantias + $cesantias) - $previousPaidCesantias;
        $accumulatedInterestDeCesantias = ($previousInterestDeCesantias + $interestDeCesantias) - $previousPaidInterestDeCesantias;
        $accumulatedPrima = ($previousPrima + $prima) - $previousPaidPrima;
        $accumulatedVacation = ($previousVacation + $vacation) - $previousPaidVacation;
        $accumulatedIndemnization = ($previousIndemnization + $indemnization) - $previousPaidIndemnization;
        $accumulatedProvisionsTotal = $accumulatedCesantias + $accumulatedInterestDeCesantias + $accumulatedPrima + $accumulatedVacation + $accumulatedIndemnization;


        // Balances
        $balanceCesantias = $accumulatedCesantias - $currentPaidCesantias;
        $balanceInterestDeCesantias = $accumulatedInterestDeCesantias - $currentPaidInterestDeCesantias;
        $balancePrima = $accumulatedPrima - $currentPaidPrima;
        $balanceVacation = $accumulatedVacation - $currentPaidVacation;
        $balanceIndemnization = $accumulatedIndemnization - $currentPaidIndemnization;

        $balanceProvisionsTotal = $balanceVacation + $balanceIndemnization + $balanceCesantias + $balanceInterestDeCesantias + $balancePrima;

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
            'operationalCosts'  => $operationalCosts,
            'icbfContribution' => $icbfContribution,
            'senaContribution' => $senaContribution,
            'arlContribution' => $arlContribution,
            'compensationFundContribution' => $compensationFundContribution,
            'cesantias' => $cesantias,
            'interestDeCesantias' => $interestDeCesantias,
            'prima' => $prima,
            'vacation' => $vacation,
            'indemnization' => $indemnization,
            'hasPreviousRecords' => !empty($previousRecords),
            'accumulatedCesantias' => $accumulatedCesantias,
            'accumulatedInterestDeCesantias' => $accumulatedInterestDeCesantias,
            'accumulatedPrima' => $accumulatedPrima,
            'accumulatedVacation' => $accumulatedVacation,
            'accumulatedIndemnization' => $accumulatedIndemnization,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,

            'paymentProvisions' => $record->paymentProvisions,
            'balanceIndemnization' => $balanceIndemnization,
            'balanceCesantias' => $balanceCesantias,
            'balanceInterestDeCesantias' => $balanceInterestDeCesantias,
            'balancePrima' => $balancePrima,
            'balanceVacation' => $balanceVacation,
            'balanceProvisionsTotal' => $balanceProvisionsTotal,
        ];
    }
}
