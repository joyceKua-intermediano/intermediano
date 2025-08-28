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
            '13th Salary' => 0.0833333,
            'Vacation' => 0.0833333,
            'Termination' => 0.0833333,
            'Indemnization' => 0.0833333,
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
        $quotations = Quotation::where('cluster_name', $clusterName)
            ->where('is_payroll', 1)
            ->whereNull('deleted_at')
            ->get();
        
        $totalAccruedLocal = 0;
        $provisionTypes = [];
        $currencyInfo = null;

        \Log::info("Processing cluster: {$clusterName}");
        \Log::info("Found quotations: " . $quotations->count());
        \Log::info("Cluster name in lowercase: " . strtolower($clusterName));
        \Log::info("Available multipliers: " . json_encode(array_keys(self::CLUSTER_MULTIPLIERS)));

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

            \Log::info("Cluster: {$clusterName}, Multipliers found: " . count($multipliers));
            \Log::info("Gross income: {$grossIncome}");

            foreach ($multipliers as $type => $multiplier) {
                $localAmount = $multiplier * $grossIncome;
                $totalAccruedLocal += $localAmount;

                if (!isset($provisionTypes[$type])) {
                    $provisionTypes[$type] = ['local' => 0];
                }
                $provisionTypes[$type]['local'] += $localAmount;
            }
        }

        \Log::info("Final total - Local: {$totalAccruedLocal}");

        $totalPaidLocal = PaymentProvision::where('cluster_name', $clusterName)->sum('amount');
        $netBalanceLocal = $totalAccruedLocal - $totalPaidLocal;
        
        // Debug: Final summary
        \Log::info("=== FINAL SUMMARY ===");
        \Log::info("Local - Accrued: {$totalAccruedLocal}, Paid: {$totalPaidLocal}, Balance: {$netBalanceLocal}");
        
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
