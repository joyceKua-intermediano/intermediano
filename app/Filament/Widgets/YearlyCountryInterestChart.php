<?php

namespace App\Filament\Widgets;

use App\Helpers\ChartColorHelper;
use App\Models\Investment;
use Filament\Widgets\ChartWidget;

class YearlyCountryInterestChart extends ChartWidget
{
    public ?string $filter = null;

    public function __construct()
    {
        $this->filter = now()->year;
    }
    protected static ?int $sort = 2;

    protected static ?string $heading = 'Total Investment by Country';

    protected function getData(): array
    {
        // Adjust the query to include exchange rate logic
        $data = Investment::selectRaw(
            'countries.name as country_name, ' .
                'SUM(capital / ' .
                'CASE ' .
                'WHEN countries.use_real_time_conversion = 1 THEN IFNULL(countries.converted_currency_quota, 1) ' .
                'ELSE IFNULL(currency.currency_quota, 1) ' .
                'END) as total_investment_usd'
        )
            ->join('countries', 'countries.id', '=', 'investments.country_id')
            ->join('currencies as currency', 'currency.id', '=', 'investments.currency_id')
            ->groupBy('investments.country_id', 'countries.name')
            ->orderByDesc('total_investment_usd')
            ->whereYear('deposit_date', $this->filter)
            ->get();

        // Extract the country names and investment totals for the chart
        $labels = $data->pluck('country_name')->toArray();
        $values = $data->pluck('total_investment_usd')->toArray();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => $values,
                    'backgroundColor' => array_map(
                        fn($labels) => ChartColorHelper::getColor($labels),
                        $labels
                    ),
                    'hoverBackgroundColor' => array_map(
                        fn($labels) => ChartColorHelper::getColor($labels) . 'AA',
                        $labels
                    ),
                    'borderColor' => '#ffffff',
                    'borderWidth' => 2,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        // Calculate the total investment for all countries, considering the exchange rate
        $totalInvestment = Investment::selectRaw(
            'SUM(capital / ' .
                'CASE ' .
                'WHEN countries.use_real_time_conversion = 1 THEN IFNULL(countries.converted_currency_quota, 1) ' .
                'ELSE IFNULL(currency.currency_quota, 1) ' .
                'END) as total_investment_usd'
        )
            ->join('countries', 'countries.id', '=', 'investments.country_id')
            ->join('currencies as currency', 'currency.id', '=', 'investments.currency_id')
            ->whereYear('deposit_date', $this->filter)
            ->first()
            ->total_investment_usd;

        $currentYear = now()->year;

        return [
            'plugins' => [
                'legend' => [
                    'position' => 'right',
                    'labels' => [
                        'boxWidth' => 15,
                        'padding' => 10,
                        'font' => [
                            'size' => 12,
                        ],
                    ],
                ],
                'title' => [
                    'display' => true,
                    'text' => "Total Investment by Country for {$currentYear} - USD " . number_format($totalInvestment, 2),
                    'font' => [
                        'size' => 16,
                        'weight' => 'bold',
                    ],
                    'padding' => 20,
                ],
            ],
            'scales' => [
                'x' => [
                    'display' => false,
                ],
                'y' => [
                    'display' => false,
                ],
            ],
            'height' => 500,
            'cutout' => '40%',
            'maintainAspectRatio' => false,
        ];
    }
}
