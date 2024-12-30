<?php

namespace App\Filament\Widgets;

use App\Helpers\ChartColorHelper;
use App\Helpers\ExchangeRateHelper;
use App\Models\Country;
use App\Models\Investment;
use Filament\Widgets\ChartWidget;

class MonthlyCountryInterestChart extends ChartWidget
{
    protected static ?int $sort = 1;

    protected static ?string $heading = 'Monthly Total Interest by Country';


    protected function getData(): array
    {
        $investmentsMonthlyPerCountry = Investment::all()->groupBy('country_id')->map(function ($investments, $countryId) {
            $countryName = Country::find($countryId)->name ?? 'Unknown';

            $monthlyData = collect([
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ])->map(function ($month) use ($investments) {
                $monthlyInvestments = $investments->filter(function ($investment) use ($month) {
                    return \Carbon\Carbon::parse($investment->deposit_date)->format('F') === $month;
                });

                return $monthlyInvestments->sum(function ($investment){
                    $capital = $investment->capital ?? 0;
                    $exchangeRate = ExchangeRateHelper::getExchangeRateForInvestment($investment);
                    return $capital / $exchangeRate;
                });
            });

            return [
                'label' => $countryName,
                'data' => $monthlyData->toArray(),
                'backgroundColor' => ChartColorHelper::getColor($countryName),
            ];
        });

        return [
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], // X-axis labels (months)
            'datasets' => $investmentsMonthlyPerCountry->values()->toArray(),
        ];
    }


    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'x' => [
                    'stacked' => true, 
                ],
                'y' => [
                    'stacked' => true, 
                    'title' => [
                        'display' => true,
                        'text' => 'Total Interest (USD)',
                    ],
                ],
            ],
            'maintainAspectRatio' => true,
        ];
    }
}
