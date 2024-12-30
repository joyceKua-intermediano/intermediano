<?php

namespace App\Filament\Widgets;

use App\Helpers\ExchangeRateHelper;
use App\Models\Investment;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class DashboardChart extends ChartWidget
{
    protected static ?int $sort = 1;

    protected static ?string $heading = '2024 Investments';

    public ?string $filter = '2024';

    protected function getFilters(): ?array
    {
        $availableYears = $this->getAvailableYears();
        $filterOptions = [];

        foreach ($availableYears as $year) {
            $filterOptions[$year] = $year;
        }

        return $filterOptions;
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        $filteredData = $this->getMonthlyCapitalData($activeFilter);

        return [
            'datasets' => [
                [
                    'label' => 'Monthly Capital (USD)',
                    'data' => $filteredData['data'],
                    'backgroundColor' => 'rgba(125, 43, 29, 0.2)',
                    'borderColor' => '#7D2B1D',
                    'borderWidth' => 2,
                    'fill' => true,
                ],
            ],
            'labels' => $filteredData['labels'],
        ];
    }

    protected function getAvailableYears(): array
    {
        return Investment::all()
            ->groupBy(function ($investment) {
                return Carbon::parse($investment->deposit_date)->format('Y');
            })
            ->keys()
            ->toArray();
    }

    protected function getMonthlyCapitalData($year): array
    {

        $monthlyCapital = Investment::whereYear('deposit_date', $year)
            ->get()
            ->groupBy(function ($investment) {
                return Carbon::parse($investment->deposit_date)->format('m');
            })
            ->map(function ($investments, $month) {
                return $investments->sum(function ($investment) {
                    $capital = $investment->capital ?? 0;
                    $exchangeRate = ExchangeRateHelper::getExchangeRateForInvestment($investment);
                    return $capital / $exchangeRate;
                });
            });

        $allMonths = collect([
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
        ]);

        $sortedMonthlyCapital = $allMonths->map(function ($month, $index) use ($monthlyCapital) {
            $monthIndex = $index + 1;
            return $monthlyCapital->get(str_pad($monthIndex, 2, '0', STR_PAD_LEFT), 0);
        });

        return [
            'labels' => $allMonths->toArray(),
            'data' => $sortedMonthlyCapital->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
