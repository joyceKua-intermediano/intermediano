<?php

if (!function_exists('calculateMexicoQuotation')) {
    function calculateMexicoQuotation($record, $previousRecords)
    {

        $previousVacation = 0;
        $previousSalary13th = 0;
        $previousVacationPrime = 0;
        $previousIndemnization90 = 0;
        $previousIndemnization20 = 0;
        $previousPtu = 0;

        $previousPaidVacation = 0;
        $previousPaidSalary13th = 0;
        $previousPaidVacationPrime = 0;
        $previousPaidIndemnization90 = 0;
        $previousPaidIndemnization20 = 0;
        $previousPaidPtu = 0;

        $grossSalary = $record->gross_salary;

        // Ordinary
        $totalGrossIncome =
            $record->gross_salary +
            $record->bonus +
            $record->transport_allowance +
            $record->food_allowance;
        $payrollTax = $totalGrossIncome * 0.04;
        $workRisk = $totalGrossIncome * 0.0266;
        $fixContribution = $totalGrossIncome * 0.0252;
        $cashBenefits = $totalGrossIncome * 0.0070;
        $disabilityInsurance = $totalGrossIncome * 0.0175;
        $kindergarten = $totalGrossIncome * 0.01;
        $pensionBeneficiaries = $totalGrossIncome * 0.0105;
        $retirement = $totalGrossIncome * 0.02;
        $oldAge = $totalGrossIncome * 0.06422;
        $infonavit = $totalGrossIncome * 0.05;


        $payrollCostsTotal =
            $payrollTax +
            $workRisk +
            $fixContribution +
            $cashBenefits +
            $disabilityInsurance +
            $kindergarten +
            $pensionBeneficiaries +
            $retirement +
            $oldAge +
            $infonavit;

        $salary13th = 0.0417 * $totalGrossIncome;
        $vacationPrime = 0.008333333 * $totalGrossIncome;
        $vacation = 0.0333333 * $totalGrossIncome;
        $indemnization90 = 0.25 * $totalGrossIncome;
        $indemnization20 = 0.0561 * $totalGrossIncome;
        $ptu = 0.01 * $totalGrossIncome;
        $provisionsTotal = $salary13th + $vacationPrime + $vacation + $indemnization90 + $indemnization20 + $ptu;

        // accumulated provision
        if ($previousRecords && $previousRecords->count()) {
            foreach ($previousRecords as $item) {
                $gross = $item->gross_salary +
                    $item->bonus +
                    $item->transport_allowance +
                    $item->food_allowance;

                $previousVacation += 0.0333333 * $gross;
                $previousSalary13th += 0.0417 * $gross;
                $previousVacationPrime += 0.008333333 * $gross;
                $previousIndemnization90 += 0.25 * $gross;
                $previousIndemnization20 += 0.0561 * $gross;
                $previousPtu += 0.01 * $gross;


                // Payments
                $previousPaidVacation += $item->paymentProvisions->where('provisionType.name', 'Vacation')->sum('amount');
                $previousPaidSalary13th += $item->paymentProvisions->where('provisionType.name', '13th Salary')->sum('amount');
                $previousPaidVacationPrime += $item->paymentProvisions->where('provisionType.name', 'Vacation Prime - 25%')->sum('amount');
                $previousPaidIndemnization90 += $item->paymentProvisions->where('provisionType.name', 'Indemnization 90 days')->sum('amount');
                $previousPaidIndemnization20 += $item->paymentProvisions->where('provisionType.name', 'Indemnization 20 days')->sum('amount');
                $previousPaidPtu += $item->paymentProvisions->where('provisionType.name', 'PTU')->sum('amount');


            }
        }
        // end of accumulated provision
        $otherCost = $record->home_allowance + $record->internet_allowance + $record->medical_allowance;
        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal + $otherCost;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee + $bankFee;
        $municipalTax = 0 * $subTotal;
        $servicesTaxes = $subTotal * 0.16;
        $totalInvoice = $bankFee + $servicesTaxes + $subTotal;

        // current payment

        $currentPaidVacation = $record->paymentProvisions
            ->where('provisionType.name', 'Vacation')
            ->sum('amount');

        $currentPaidSalary13th = $record->paymentProvisions
            ->where('provisionType.name', '13th Salary')
            ->sum('amount');
        $currentPaidVacationPrime = $record->paymentProvisions
            ->where('provisionType.name', 'Vacation Prime - 25%')
            ->sum('amount');

        $currentPaidIndemnization90 = $record->paymentProvisions
            ->where('provisionType.name', 'Indemnization 90 days')
            ->sum('amount');
        $currentPaidIndemnization20 = $record->paymentProvisions
            ->where('provisionType.name', 'Indemnization 20 days')
            ->sum('amount');

        $currentPaidPtu = $record->paymentProvisions
            ->where('provisionType.name', 'PTU')
            ->sum('amount');

        // All-time payments

        $totalPaidVacation = $previousPaidVacation + $currentPaidVacation;
        $totalPaidSalary13th = $previousPaidSalary13th + $currentPaidSalary13th;
        $totalPaidVacationPrime = $previousPaidVacationPrime + $currentPaidVacationPrime;
        $totalPaidIndemnization90 = $previousPaidIndemnization90 + $currentPaidIndemnization90;
        $totalPaidIndemnization20 = $previousPaidIndemnization20 + $currentPaidIndemnization20;
        $totalPaidPtu = $previousPaidPtu + $currentPaidPtu;


        // accumulated

        $accumulatedVacation = ($previousVacation + $vacation) - $previousPaidVacation;
        $accumulatedSalary13th = ($previousSalary13th + $salary13th) - $previousPaidSalary13th;
        $accumulatedVacationPrime = ($previousVacationPrime + $vacationPrime) - $previousPaidVacationPrime;
        $accumulatedIndemnization90 = ($previousIndemnization90 + $indemnization90) - $previousPaidIndemnization90;
        $accumulatedIndemnization20 = ($previousIndemnization20 + $indemnization20) - $previousPaidIndemnization20;
        $accumulatedPtu = ($previousPtu + $ptu) - $previousPaidPtu;


        $accumulatedProvisionsTotal = $accumulatedVacation + $accumulatedSalary13th + $accumulatedVacationPrime + $accumulatedIndemnization90 + $accumulatedIndemnization20 + $accumulatedPtu;

        // Balances

        $balanceVacation = $accumulatedVacation - $currentPaidVacation;
        $balanceSalary13th = $accumulatedSalary13th - $currentPaidSalary13th;
        $balanceVacationPrime = $accumulatedVacationPrime - $currentPaidVacationPrime;
        $balanceIndemnization90 = $accumulatedIndemnization90 - $currentPaidIndemnization90;
        $balanceIndemnization20 = $accumulatedIndemnization20 - $currentPaidIndemnization20;
        $balancePtu = $accumulatedPtu - $currentPaidPtu;


        $balanceProvisionsTotal = $balanceVacation + $balanceSalary13th + $balanceVacationPrime + $balanceIndemnization90 + $balanceIndemnization20 + $balancePtu;


        return [
            'grossSalary' => $grossSalary,
            'totalGrossIncome' => $totalGrossIncome,
            'otherCost' => $otherCost,
            'subTotalGrossPayroll' => $subTotalGrossPayroll,
            'fee' => $fee,
            'bankFee' => $bankFee,
            'subTotal' => $subTotal,
            'municipalTax' => $municipalTax,
            'servicesTaxes' => $servicesTaxes,
            'totalInvoice' => $totalInvoice,
            'payrollTax' => $payrollTax,
            'workRisk' => $workRisk,
            'fixContribution' => $fixContribution,
            'cashBenefits' => $cashBenefits,
            'disabilityInsurance' => $disabilityInsurance,
            'kindergarten' => $kindergarten,
            'pensionBeneficiaries' => $pensionBeneficiaries,
            'retirement' => $retirement,
            'oldAge' => $oldAge,
            'infonavit' => $infonavit,
            'payrollCostsTotal' => $payrollCostsTotal,
            'salary13th' => $salary13th,
            'vacationPrime' => $vacationPrime,
            'vacation' => $vacation,
            'indemnization90' => $indemnization90,
            'indemnization20' => $indemnization20,
            'ptu' => $ptu,
            'provisionsTotal' => $provisionsTotal,
            'hasPreviousRecords' => !empty($previousRecords),

            'accumulatedSalary13th' => $accumulatedSalary13th,
            'accumulatedVacationPrime' => $accumulatedVacationPrime,
            'accumulatedVacation' => $accumulatedVacation,
            'accumulatedIndemnization90' => $accumulatedIndemnization90,
            'accumulatedIndemnization20' => $accumulatedIndemnization20,
            'accumulatedPtu' => $accumulatedPtu,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,

            'paymentProvisions' => $record->paymentProvisions,
            'balanceVacation' => $balanceVacation,
            'balanceSalary13th' => $balanceSalary13th,
            'balanceVacationPrime' => $balanceVacationPrime,
            'balanceIndemnization90' => $balanceIndemnization90,
            'balanceIndemnization20' => $balanceIndemnization20,
            'balancePtu' => $balancePtu,
            'balanceProvisionsTotal' => $balanceProvisionsTotal,
        ];
    }
}
