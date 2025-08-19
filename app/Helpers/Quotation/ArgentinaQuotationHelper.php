<?php

if (!function_exists('calculateArgentinaQuotation')) {
    function calculateArgentinaQuotation($record, $previousRecords)
    {
        $grossSalary = $record->gross_salary;
        $nationalHolidayplus = (($grossSalary / 25) - ($grossSalary / 30)) * 2;
        // Ordinary
        $totalGrossIncome =
            $record->gross_salary +
            $nationalHolidayplus +
            $record->bonus +
            $record->home_allowance +
            $record->transport_allowance +
            $record->medical_allowance +
            $record->legal_grafication +
            $record->internet_allowance;

        $jubilacion = $totalGrossIncome * 0.1077;
        $socialSecurityINSSJP = $totalGrossIncome * 0.0159;
        $nEFund = $totalGrossIncome * 0.0095;
        $familySalary = $totalGrossIncome * 0.0470;
        $ansal = $totalGrossIncome * 0.06;
        $workRiskInsuranceART = ($totalGrossIncome * 0.0223) + 350;
        $lifeInsuranceSVO = 7046; //$totalGrossIncome * 0.007269
        $osde = $totalGrossIncome * 0.0;

        $payrollCostsLists = ['jubilacion', 'socialSecurityINSSJP', 'nEFund', 'familySalary', 'ansal', 'workRiskInsuranceART', 'lifeInsuranceSVO', 'osde'];


        $payrollCostsTotal = $jubilacion + $socialSecurityINSSJP + $nEFund + $familySalary + $ansal + $workRiskInsuranceART + $lifeInsuranceSVO + $osde;

        $christmasBonus = 0.0833 * $totalGrossIncome;
        $vacations = 0.0389 * $totalGrossIncome;
        $vacationsPlus = 0.0078 * $totalGrossIncome;
        $christmasBonusOverVacation = 0.0039 * $totalGrossIncome;
        $forewarningSAC = 0.0833 * $totalGrossIncome * 0;
        $christmasBonusOverForewarning = 0.0833 * $totalGrossIncome * 0;
        $compensationForYearsOfService = 0.1666 * $totalGrossIncome * 0;
        $provisionLists = ['christmasBonus', 'vacations', 'vacationsPlus', 'christmasBonusOverVacation', 'forewarningSAC', 'christmasBonusOverForewarning', 'compensationForYearsOfService'];

        $provisionsTotal = $christmasBonus + $vacations + $vacationsPlus + $christmasBonusOverVacation + $forewarningSAC + $christmasBonusOverForewarning + $compensationForYearsOfService;

        // accumulated provision
        if ($previousRecords && $previousRecords->count()) {
            $previousMonthGrossIncome = $previousRecords->gross_salary +
                $previousRecords->bonus +
                $previousRecords->home_allowance +
                $previousRecords->transport_allowance +
                $previousRecords->medical_allowance +
                $previousRecords->legal_grafication +
                $previousRecords->internet_allowance;
        } else {
            $previousMonthGrossIncome = 0;
        }
        ;

        $accumulatedChristmasBonus = (0.0417 * $previousMonthGrossIncome) + $christmasBonus;
        $accumulatedVacations = (0.0417 * $previousMonthGrossIncome) + $vacations;
        $accumulatedVacationsPlus = (0.0417 * $previousMonthGrossIncome) + $vacationsPlus;
        $accumulatedChristmasBonusOverVacation = (0.0417 * $previousMonthGrossIncome) + $christmasBonusOverVacation;
        $accumulatedForewarningSAC = (0.0417 * $previousMonthGrossIncome) + $forewarningSAC;
        $accumulatedChristmasBonusOverForewarning = (0.0417 * $previousMonthGrossIncome) + $christmasBonusOverForewarning;
        $accumulatedCompensationForYearsOfService = (0.0417 * $previousMonthGrossIncome) + $compensationForYearsOfService;
        $accumulatedLists = ['accumulatedChristmasBonus', 'accumulatedVacations', 'accumulatedVacationsPlus', 'accumulatedChristmasBonusOverVacation', 'accumulatedForewarningSAC', 'accumulatedChristmasBonusOverForewarning', 'accumulatedCompensationForYearsOfService'];

        $accumulatedProvisionsTotal = $accumulatedChristmasBonus + $accumulatedVacations + $accumulatedVacationsPlus + $accumulatedChristmasBonusOverVacation + $accumulatedForewarningSAC + $accumulatedChristmasBonusOverForewarning + $accumulatedCompensationForYearsOfService;
        // end of accumulated provision

        $subTotalGrossPayroll = $totalGrossIncome + $provisionsTotal + $payrollCostsTotal;
        $fee = $record->is_fix_fee ? $record->fee * $record->exchange_rate : $subTotalGrossPayroll * ($record->fee / 100);
        $bankFee = $record->bank_fee * $record->exchange_rate;
        $subTotal = $subTotalGrossPayroll + $fee + $bankFee;
        $servicesTaxes = $subTotal * 0.0150;
        $bankFeePercentage = $subTotal * 0.01250;

        $totalInvoice = $subTotal + $servicesTaxes + $bankFeePercentage;

        return [
            'nationalHolidayplus' => $nationalHolidayplus,
            'grossSalary' => $grossSalary,
            'totalGrossIncome' => $totalGrossIncome,
            'payrollCostsTotal' => $payrollCostsTotal,
            'provisionsTotal' => $provisionsTotal,
            'subTotalGrossPayroll' => $subTotalGrossPayroll,
            'fee' => $fee,
            'bankFee' => $bankFee,
            'subTotal' => $subTotal,
            'bankFeePercentage' =>  $bankFeePercentage,
            'servicesTaxes' => $servicesTaxes,
            'totalInvoice' => $totalInvoice,
            'christmasBonus' => $christmasBonus,
            'vacations' => $vacations,
            'vacationsPlus' => $vacationsPlus,
            'christmasBonusOverVacation' => $christmasBonusOverVacation,
            'forewarningSAC' => $forewarningSAC,
            'christmasBonusOverForewarning' => $christmasBonusOverForewarning,
            'compensationForYearsOfService' => $compensationForYearsOfService,
            'provisionLists' => $provisionLists,
            'jubilacion' => $jubilacion,
            'socialSecurityINSSJP' => $socialSecurityINSSJP,
            'nEFund' => $nEFund,
            'familySalary' => $familySalary,
            'ansal' => $ansal,
            'workRiskInsuranceART' => $workRiskInsuranceART,
            'lifeInsuranceSVO' => $lifeInsuranceSVO,
            'osde' => $osde,
            'payrollCostsLists' => $payrollCostsLists,
            'previousMonthGrossIncome' => $previousMonthGrossIncome,
            'accumulatedLists' => $accumulatedLists,
            'accumulatedProvisionsTotal' => $accumulatedProvisionsTotal,
        ];
    }
}
