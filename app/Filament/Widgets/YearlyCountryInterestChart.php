<?php

namespace App\Filament\Widgets;

use App\Helpers\ChartColorHelper;
use App\Models\Investment;
use Filament\Widgets\ChartWidget;

class YearlyCountryInterestChart extends ChartWidget
{
    public ?string $filter = null;

    public ?string $headerTitle = '';
    public function __construct()
    {
        $this->filter = now()->year;
    }
    protected static ?int $sort = 2;

    protected static ?string $heading = 'Total Investment by Country';

    protected function getData(): array
    {
        $activeFilter = $this->filter;
        $data = Investment::selectRaw(
            'countries.name as country_name, ' .
                'SUM(capital / ' .
                'CASE ' .
                'WHEN countries.use_real_time_conversion = 1 THEN ' .
                    'CASE ' .
                    'WHEN currency.converted_currency_quota IS NOT NULL AND currency.converted_currency_quota != 0 ' .
                    'THEN currency.converted_currency_quota ' .
                    'ELSE IFNULL(currency.currency_quota, 1) ' .
                    'END ' .
                'ELSE IFNULL(currency.currency_quota, 1) ' .
                'END) as total_investment_usd'
        )
            ->join('countries', 'countries.id', '=', 'investments.country_id')
            ->join('currencies as currency', 'currency.id', '=', 'investments.currency_id')
            ->groupBy('investments.country_id', 'countries.name')
            ->orderByDesc('total_investment_usd')
            ->whereYear('deposit_date', $activeFilter)
            ->get();

        $labels = $data->pluck('country_name')->toArray();
        $values = $data->pluck('total_investment_usd')->toArray();
        $this->headerTitle = "Total Investment by Country for {$activeFilter} - USD " . number_format($data->sum('total_investment_usd'), 2);
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
        $activeFilter = $this->filter;

        $totalInvestment = Investment::selectRaw(
            'SUM(capital / ' .
                'CASE ' .
                'WHEN countries.use_real_time_conversion = 1 THEN IFNULL(currency.converted_currency_quota, 1) ' .
                'ELSE IFNULL(currency.currency_quota, 1) ' .
                'END) as total_investment_usd'
        )
            ->join('countries', 'countries.id', '=', 'investments.country_id')
            ->join('currencies as currency', 'currency.id', '=', 'investments.currency_id')
            ->whereYear('deposit_date', $activeFilter)
            ->first()
            ->total_investment_usd;


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

    protected function getAvailableYears(): array
    {
        return Investment::select('year')->get()->groupBy('year')->keys()->toArray();
    }

    protected function getFilters(): ?array
    {
        $availableYears = $this->getAvailableYears();
        $filterOptions = [];

        foreach ($availableYears as $year) {
            $filterOptions[$year] = $year;
        }

        return $filterOptions;
    }


    public function getHeading(): string|null
    {
        return $this->headerTitle;
    }
}
