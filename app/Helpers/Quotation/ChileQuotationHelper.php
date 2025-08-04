<?php

if (!function_exists('calculateChileQuotation')) {
    function calculateChileQuotation($record, $previousRecords)
    {


        $previousVacation = 0;
        $previousCompensation = 0;
        $previousNoticePeriod = 0;

        $previousPaidVacation = 0;
        $previousPaidCompensation = 0;
        $previousPaidNoticePeriod = 0;

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

        $employerContribution = $totalGrossIncome * 0.0375;
        $unEmploymentInsurance = $totalGrossIncome * 0.03;
        $disabilityInsurance = $totalGrossIncome * 0.0199;
        // dd($record->payrollCosts);
        $insurance = 0.53 * $record->payrollCosts->uf_month;
        $operationalCosts = 1.2397 * $record->payrollCosts->uf_month;

        $payrollCostsTotal =
            $employerContribution +
            $unEmploymentInsurance +
            $disabilityInsurance +
            $insurance +
            $operationalCosts;

        $vacation = 0.058333 * $totalGrossIncome;
        $compensation = 0.0833 * $totalGrossIncome;
        $noticePeriod = 0.0833 * $totalGrossIncome;
        $provisionsTotal = $vacation + $compensation + $noticePeriod;

        if ($previousRecords && $previousRecords->count()) {
            foreach ($previousRecords as $item) {
                $gross = $item->gross_salary +
                    $item->bonus +
                    $item->home_allowance +
                    $record->legal_grafication +
                    $item->transport_allowance +
                    $item->medical_allowance +
                    $item->internet_allowance;


                $previousVacation += 0.058333 * $gross;
                $previousCompensation += 0.0833 * $gross;
                $previousNoticePeriod += 0.0833 * $gross;


                // Payments
                $previousPaidVacation += $item->paymentProvisions->where('provisionType.name', 'Vacation')->sum('amount');
                $previousPaidCompensation += $item->paymentProvisions->where('provisionType.name', 'Compensation for years of service')->sum('amount');
                $previousPaidNoticePeriod += $item->paymentProvisions->where('provisionType.name', 'Termination - Notice period')->sum('amount');

            }
        }

        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $totalGrossIncome * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee + $bankFee;
        $municipalTax = 0 * $subTotal;
        $servicesTaxes = $subTotal * 0.19;
        $totalInvoice = $subTotal + $municipalTax + $servicesTaxes;

        // current payment

        $currentPaidVacation = $record->paymentProvisions
            ->where('provisionType.name', 'Vacation')
            ->sum('amount');

        $currentPaidCompensation = $record->paymentProvisions
            ->where('provisionType.name', 'Compensation for years of service')
            ->sum('amount');

        $currentPaidNoticePeriod = $record->paymentProvisions
            ->where('provisionType.name', 'Notice period')
            ->sum('amount');

        // All-time payments

        $totalPaidVacation = $previousPaidVacation + $currentPaidVacation;
        $totalPaidCompensation = $previousPaidCompensation + $currentPaidCompensation;
        $totalPaidNoticePeriod = $previousPaidNoticePeriod + $currentPaidNoticePeriod;

        // accumulated

        $accumulatedVacation = ($previousVacation + $vacation) - $previousPaidVacation;
        $accumulatedCompensation = ($previousCompensation + $compensation) - $previousPaidCompensation;
        $accumulatedNoticePeriod = ($previousNoticePeriod + $noticePeriod) - $previousPaidNoticePeriod;


        $accumulatedProvisionsTotal = $accumulatedNoticePeriod + $accumulatedVacation + $accumulatedCompensation;

        // Balances

        $balanceVacation = $accumulatedVacation - $currentPaidVacation;
        $balanceCompensation = $accumulatedCompensation - $currentPaidCompensation;
        $balanceNoticePeriod = $accumulatedNoticePeriod - $currentPaidNoticePeriod;

        $balanceProvisionsTotal = $balanceVacation + $balanceCompensation + $balanceNoticePeriod;

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
            'employerContribution' => $employerContribution,
            'unEmploymentInsurance' => $unEmploymentInsurance,
            'disabilityInsurance' => $disabilityInsurance,
            'insurance' => $insurance,
            'operationalCosts' => $operationalCosts,
            'vacation' => $vacation,
            'compensation' => $compensation,
            'noticePeriod' => $noticePeriod,
            'hasPreviousRecords' => !empty($previousRecords),
            'accumulatedVacation' => $accumulatedVacation,
            'accumulatedCompensation' => $accumulatedCompensation,
            'accumulatedNoticePeriod' => $accumulatedNoticePeriod,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,

            'paymentProvisions' => $record->paymentProvisions,
            'balanceVacation' => $balanceVacation,
            'balanceCompensation' => $balanceCompensation,
            'balanceNoticePeriod' => $balanceNoticePeriod,
            'balanceProvisionsTotal' => $balanceProvisionsTotal,
        ];
    }
}
