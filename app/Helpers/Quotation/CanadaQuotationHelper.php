<?php

if (!function_exists('calculateCanadaQuotation')) {
    function calculateCanadaQuotation($record, $previousRecords)
    {
        $previousVacation = 0;
        $previousIndemnization = 0;

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
            $record->legal_grafication +
            $record->internet_allowance;

        $canadanPension = .0595 * (71300-3500) / 12;
        $canadanPensionPlan2 = .04 * (81200-71300) / 12;
        $employmentInsurance = $totalGrossIncome * .0230;
        $employerHealthTax = $totalGrossIncome * 0.0195;
        $workerCompensation = $totalGrossIncome * .0155;
        $glInsurance = $totalGrossIncome * .01;


        $payrollCostsTotal =
            $canadanPension +
            $employmentInsurance +
            $canadanPensionPlan2 +
            $workerCompensation;

        $vacation = 0.0416 * $totalGrossIncome;
        $indemnification = 0.0208 * $totalGrossIncome;
        $provisionsTotal = $vacation + $indemnification;

        // accumulated provision
        if ($previousRecords && $previousRecords->count()) {
            foreach ($previousRecords as $item) {
                $gross = $item->gross_salary +
                    $item->bonus +
                    $item->home_allowance +
                    $item->transport_allowance +
                    $item->medical_allowance +
                    $item->internet_allowance;

                $previousVacation += 0.0416 * $gross;
                $previousIndemnization += 0.0833 * $gross;


                // Payments
                $previousPaidVacation += $item->paymentProvisions->where('provisionType.name', 'Vacation')->sum('amount');
                $previousPaidIndemnization += $item->paymentProvisions->where('provisionType.name', 'Indemnification')->sum('amount');

            }
        }

        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee;
        $municipalTax = 0 * $subTotal;
        $servicesTaxes = $subTotal * 0.19;
        $totalInvoice = $subTotal + $bankFee;

        // current payment

        $currentPaidVacation = $record->paymentProvisions
            ->where('provisionType.name', 'Vacation')
            ->sum('amount');

        $currentPaidIndemnization = $record->paymentProvisions
            ->where('provisionType.name', 'Indemnification')
            ->sum('amount');


        // All-time payments
        $totalPaidVacation = $previousPaidVacation + $currentPaidVacation;
        $totalPaidIndemnization = $previousPaidIndemnization + $currentPaidIndemnization;

        // accumulated
        $accumulatedVacation = ($previousVacation + $vacation) - $previousPaidVacation;
        $accumulatedIndemnification = ($previousIndemnization + $indemnification) - $previousPaidIndemnization;


        $accumulatedProvisionsTotal = $accumulatedIndemnification + $accumulatedVacation;

        // Balances
        $balanceVacation = $accumulatedVacation - $currentPaidVacation;
        $balanceIndemnization = $accumulatedIndemnification - $currentPaidIndemnization;

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
            'canadanPension' => $canadanPension,
            'employmentInsurance' => $employmentInsurance,
            'employerHealthTax' => $employerHealthTax,
            'workerCompensation' => $workerCompensation,
            'canadanPensionPlan2' => $canadanPensionPlan2,
            'glInsurance' => $glInsurance,
            'vacation' => $vacation,
            'indemnification' => $indemnification,
            'hasPreviousRecords' => !empty($previousRecords),

            'accumulatedVacation' => $accumulatedVacation,
            'accumulatedIndemnification' => $accumulatedIndemnification,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,

            'paymentProvisions' => $record->paymentProvisions,
            'balanceIndemnization' => $balanceIndemnization,
            'balanceVacation' => $balanceVacation,
            'balanceProvisionsTotal' => $balanceProvisionsTotal,
        ];
    }
}
