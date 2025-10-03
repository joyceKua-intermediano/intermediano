<?php
namespace App\Helpers;

use App\Models\Country;
use App\Models\Quotation;
use App\Models\PaymentProvision;

class AccruedProvisionHelper
{
    public const CLUSTER_MULTIPLIERS = [
        'intermedianodobrasilltda' => [
            '13th Salary' => 0.0833333,
            'Vacation' => 0.0833333,
            '1/3 Vacation Bonus' => 0.0278,
            'Termination' => 0.0833333,
        ],
        'intermedianocanada' => [
            'Vacation' => 0.0416,
            'Indemnification' => 0.0625,
        ],
        'intermedianochilespa' => [
            'Vacation' => 0.058333,
            'Compensation' => 0.0833,
            'Notice period' => 0.0833,
        ],
        'intermedianocostarica' => [
            'Unemployment' => 0.0533,
            'Forewarning' => 0.0833,
            'Bonus' => 0.0833,
            'Vacation' => 0.0417,
        ],
        'intermedianocolombiasas' => [
            'integral' => [
                'Vacation' => 0.0417,
                'Indemnization' => 0.056,
            ],
            'ordinary' => [
                'Cesantias' => 0.0833,
                'Interest de Cesantias' => 0.01,
                'Prima' => 0.0833,
                'Vacation' => 0.0417,
                'Indemnization' => 0.056,
            ],
        ],
        'intermedianoecuadorsas' => [
            '13th Salary' => 0.0833333,
            'Vacation' => 0.0833333,
            'Termination' => 0.0833333,
            'Bonus 13th' => 0.0833333,
            'Bonus 14th' => 0.0833333,
            '25% Bonification' => 0.0208,
        ],
        'intermedianohongkong' => [
            'Vacation' => 0.0833333,
            'Termination' => 0.0833333,
            'Christmas bonus' => 0.0833333,
        ],
        'intermedianomexicosc' => [
            'Vacation' => 0.0833333,
            'Termination' => 0.0833333,
            'Vacation Prime - 25%' => 0.0208,
            'Indemnization 90 days' => 0.25,
            'Indemnization 20 days' => 0.0556,
            'PTU' => 0.0833333,
        ],
        'intermedianoperusac' => [
            'Vacation' => 0.0833333,
            'Termination' => 0.0833333,
            'Gratification' => 0.0833333,
            'CTS' => 0.0833333,
            'Extraordinary Gratification' => 0.0833333,
        ],
        'intermedianouruguay' => [
            'Vacation' => 0.0833333,
            'Termination' => 0.0833333,
            'Vacational Salary' => 0.0833333,
            'License' => 0.0833333,
        ],
        'partnercanada' => [
            'Vacation' => 0.0416,
            'Indemnification' => 0.0625,
        ],
        'partneruruguay' => [
            'Vacation' => 0.0833333,
            'Termination' => 0.0833333,
            'Dismissal' => 0.0833333,
            'Severance' => 0.0833333,
        ],
        'partnerhongkong' => [
            'Vacation' => 0.0833333,
            'Termination' => 0.0833333,
            'Christmas bonus' => 0.0833333,
        ],
    ];

    public static function getCountryProvisionSummary(string $clusterName): array
    {
        $originalClusterName = $clusterName;
        $isIntegral = null;
        
        if (str_contains($clusterName, ' - Integral')) {
            $originalClusterName = str_replace(' - Integral', '', $clusterName);
            $isIntegral = 1;
        } elseif (str_contains($clusterName, ' - Ordinary')) {
            $originalClusterName = str_replace(' - Ordinary', '', $clusterName);
            $isIntegral = 0;
        }

        if (strtolower($originalClusterName) === 'intermedianocolombiasas') {
            if ($isIntegral === 1) {
                return self::getColombiaIntegralProvisionSummary($originalClusterName);
            } elseif ($isIntegral === 0) {
                return self::getColombiaOrdinaryProvisionSummary($originalClusterName);
            } else {
                return self::getColombiaCombinedProvisionSummary($originalClusterName);
            }
        }

        return self::getDefaultProvisionSummary($originalClusterName, $isIntegral);
    }


    private static function getColombiaIntegralProvisionSummary(string $clusterName): array
    {
        $quotations = Quotation::where('cluster_name', $clusterName)
            ->where('is_payroll', 1)
            ->where('is_integral', 1)
            ->whereNull('deleted_at')
            ->get();
        
        $totalAccruedLocal = 0;
        $provisionTypes = [];
        $currencyInfo = null;

        foreach ($quotations as $quotation) {
            if (!$currencyInfo) {
                $currencyInfo = [
                    'name' => $quotation->currency_name,
                    'acronym' => $quotation->exchange_acronym
                ];
            }

            $grossIncome = self::calculateColombiaIntegralGrossIncome($quotation);
            $multipliers = self::CLUSTER_MULTIPLIERS[strtolower($clusterName)]['integral'] ?? [];

            foreach ($multipliers as $type => $multiplier) {
                $localAmount = $multiplier * $grossIncome;
                $totalAccruedLocal += $localAmount;

                if (!isset($provisionTypes[$type])) {
                    $provisionTypes[$type] = ['local' => 0];
                }
                $provisionTypes[$type]['local'] += $localAmount;
            }
        }

        $totalPaidLocal = PaymentProvision::where('cluster_name', $clusterName)->sum('amount');
        $netBalanceLocal = $totalAccruedLocal - $totalPaidLocal;
        
        return [
            'currency' => $currencyInfo,
            'total_quotations' => $quotations->count(),
            'local' => [
                'accrued' => $totalAccruedLocal,
                'paid' => $totalPaidLocal,
                'balance' => $netBalanceLocal
            ],
            'provisionTypes' => $provisionTypes
        ];
    }
    private static function getColombiaOrdinaryProvisionSummary(string $clusterName): array
    {
        $quotations = Quotation::where('cluster_name', $clusterName)
            ->where('is_payroll', 1)
            ->where('is_integral', 0)
            ->whereNull('deleted_at')
            ->get();
        
        $totalAccruedLocal = 0;
        $provisionTypes = [];
        $currencyInfo = null;

        foreach ($quotations as $quotation) {
            if (!$currencyInfo) {
                $currencyInfo = [
                    'name' => $quotation->currency_name,
                    'acronym' => $quotation->exchange_acronym
                ];
            }

            $grossIncome = self::calculateColombiaOrdinaryGrossIncome($quotation);
            $multipliers = self::CLUSTER_MULTIPLIERS[strtolower($clusterName)]['ordinary'] ?? [];

            foreach ($multipliers as $type => $multiplier) {
                $localAmount = $multiplier * $grossIncome;
                $totalAccruedLocal += $localAmount;

                if (!isset($provisionTypes[$type])) {
                    $provisionTypes[$type] = ['local' => 0];
                }
                $provisionTypes[$type]['local'] += $localAmount;
            }
        }

        $totalPaidLocal = PaymentProvision::where('cluster_name', $clusterName)->sum('amount');
        $netBalanceLocal = $totalAccruedLocal - $totalPaidLocal;
        
        return [
            'currency' => $currencyInfo,
            'total_quotations' => $quotations->count(),
            'local' => [
                'accrued' => $totalAccruedLocal,
                'paid' => $totalPaidLocal,
                'balance' => $netBalanceLocal
            ],
            'provisionTypes' => $provisionTypes
        ];
    }

    private static function getColombiaCombinedProvisionSummary(string $clusterName): array
    {
        $integralSummary = self::getColombiaIntegralProvisionSummary($clusterName);
        $ordinarySummary = self::getColombiaOrdinaryProvisionSummary($clusterName);

        $combinedProvisions = [];
        foreach ($integralSummary['provisionTypes'] as $type => $data) {
            $combinedProvisions[$type] = ['local' => $data['local']];
        }
        foreach ($ordinarySummary['provisionTypes'] as $type => $data) {
            if (isset($combinedProvisions[$type])) {
                $combinedProvisions[$type]['local'] += $data['local'];
            } else {
                $combinedProvisions[$type] = ['local' => $data['local']];
            }
        }

        return [
            'currency' => $integralSummary['currency'] ?: $ordinarySummary['currency'],
            'total_quotations' => $integralSummary['total_quotations'] + $ordinarySummary['total_quotations'],
            'local' => [
                'accrued' => $integralSummary['local']['accrued'] + $ordinarySummary['local']['accrued'],
                'paid' => $integralSummary['local']['paid'] + $ordinarySummary['local']['paid'],
                'balance' => $integralSummary['local']['balance'] + $ordinarySummary['local']['balance']
            ],
            'provisionTypes' => $combinedProvisions
        ];
    }

    private static function calculateColombiaIntegralGrossIncome($quotation): float
    {
        return ($quotation->gross_salary ?? 0) + ($quotation->bonus ?? 0);
    }
    private static function calculateColombiaOrdinaryGrossIncome($quotation): float
    {
        return ($quotation->gross_salary ?? 0) + 
               ($quotation->bonus ?? 0) + 
               ($quotation->home_allowance ?? 0) + 
               ($quotation->transport_allowance ?? 0) + 
               ($quotation->medical_allowance ?? 0) + 
               ($quotation->internet_allowance ?? 0);
    }
    private static function getDefaultProvisionSummary(string $clusterName, ?int $isIntegral): array
    {
        $query = Quotation::where('cluster_name', $clusterName)
            ->where('is_payroll', 1)
            ->whereNull('deleted_at');
            
        if ($isIntegral !== null) {
            $query->where('is_integral', $isIntegral);
        }
        
        $quotations = $query->get();
        
        $totalAccruedLocal = 0;
        $provisionTypes = [];
        $currencyInfo = null;

        foreach ($quotations as $quotation) {
            if (!$currencyInfo) {
                $currencyInfo = [
                    'name' => $quotation->currency_name,
                    'acronym' => $quotation->exchange_acronym
                ];
            }

            $grossIncome =
                ($quotation->gross_salary ?? 0) +
                ($quotation->bonus ?? 0) +
                ($quotation->home_allowance ?? 0) +
                ($quotation->transport_allowance ?? 0) +
                ($quotation->medical_allowance ?? 0) +
                ($quotation->internet_allowance ?? 0) +
                ($quotation->legal_grafication ?? 0) +
                ($quotation->family_allowance ?? 0) +
                ($quotation->food_allowance ?? 0) +
                ($quotation->capped_amount ?? 0) +
                ($quotation->uvt_amount ?? 0) +
                ($quotation->payroll_cost_medical_insurance ?? 0);

            $multipliers = self::CLUSTER_MULTIPLIERS[strtolower($clusterName)] ?? [];

            foreach ($multipliers as $type => $multiplier) {
                $localAmount = $multiplier * $grossIncome;
                $totalAccruedLocal += $localAmount;

                if (!isset($provisionTypes[$type])) {
                    $provisionTypes[$type] = ['local' => 0];
                }
                $provisionTypes[$type]['local'] += $localAmount;
            }
        }

        $totalPaidLocal = PaymentProvision::where('cluster_name', $clusterName)->sum('amount');
        $netBalanceLocal = $totalAccruedLocal - $totalPaidLocal;
        
        return [
            'currency' => $currencyInfo,
            'total_quotations' => $quotations->count(),
            'local' => [
                'accrued' => $totalAccruedLocal,
                'paid' => $totalPaidLocal,
                'balance' => $netBalanceLocal
            ],
            'provisionTypes' => $provisionTypes
        ];
    }
}
