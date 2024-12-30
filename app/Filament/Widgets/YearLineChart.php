<?php

namespace App\Filament\Widgets;

use App\Helpers\ChartColorHelper;
use App\Helpers\ExchangeRateHelper;
use App\Models\Investment;
use Filament\Widgets\ChartWidget;

class YearLineChart extends ChartWidget
{
    protected static ?int $sort = 1;

    protected static ?string $heading = 'Chart';
    protected function getData(): array
    {
        $investments = Investment::with(['country', 'currency'])->get();

        $groupedData = $investments
            ->groupBy(function ($investment) {
                return \Carbon\Carbon::parse($investment->deposit_date)->format('Y');
            })
            ->map(function ($yearlyInvestments) {
                return $yearlyInvestments->groupBy('country.name')
                    ->map(function ($countryInvestments) {
                        return $countryInvestments->sum(function ($investment) {
                            $capital = $investment->capital ?? 0;
                            $exchangeRate = ExchangeRateHelper::getExchangeRateForInvestment($investment);
                            return $capital / ($exchangeRate ?: 1);
                        });
                    });
            });

        $allYears = $groupedData->keys()->sort()->values()->toArray();
        $allCountries = $groupedData->flatMap(function ($yearData) {
            return $yearData->keys();
        })->unique()->sort()->values()->toArray();

        $datasets = [];
        foreach ($allCountries as $index => $country) {
            $baseColor = ChartColorHelper::getColor($country);

            $countryData = collect($allYears)->map(function ($year) use ($groupedData, $country) {
                return $groupedData->get($year, collect())->get($country, 0);
            })->toArray();

            $datasets[] = [
                'label' => $country,
                'data' => $countryData,
                'borderColor' => $baseColor,
                'backgroundColor' => $this->adjustAlpha($baseColor, 0.5),
                'fill' => true,
            ];
        }

        return [
            'labels' => $allYears,
            'datasets' => $datasets,
        ];
    }
    protected function adjustAlpha(string $color, float $alpha): string
    {
        if (preg_match('/^#([a-fA-F0-9]{6})$/', $color)) {
            list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");
            return "rgba($r, $g, $b, $alpha)";
        }
        return $color;
    }

    protected function getChartColor(int $index, float $alpha = 1): string
    {
        $colors = [
            'rgba(255, 99, 132, ALPHA)',
            'rgba(54, 162, 235, ALPHA)',
            'rgba(75, 192, 192, ALPHA)',
            'rgba(255, 206, 86, ALPHA)',
            'rgba(153, 102, 255, ALPHA)',
            'rgba(255, 159, 64, ALPHA)',
            'rgba(199, 199, 199, ALPHA)',
        ];

        $color = $colors[$index % count($colors)];
        return str_replace('ALPHA', $alpha, $color);
    }
    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'plugins' => [
                'title' => [
                    'display' => true,
                    'text' => 'Investment by Country (Stacked)'
                ],
                'tooltip' => [
                    'mode' => 'index'
                ]
            ],
            'interaction' => [
                'mode' => 'nearest',
                'axis' => 'x',
                'intersect' => false
            ],
            'scales' => [
                'x' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Year'
                    ]
                ],
                'y' => [
                    'stacked' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Investment (USD)'
                    ]
                ]
            ]
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
