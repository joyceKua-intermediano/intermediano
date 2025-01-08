<?php

namespace App\Filament\Widgets;
use Carbon\Carbon;

use App\Helpers\ExchangeRateHelper;
use App\Models\Country;
use App\Models\Investment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;

class StatsDashboard extends BaseWidget
{
    public ?string $filter = null;

    public function __construct()
    {
        $this->filter = now()->year;
    }
    protected function getStats(): array
    {
        $investmentsPerCountry = Investment::whereYear('deposit_date', $this->filter)
        ->get()
            ->groupBy('country_id')
            ->map(function ($investments, $countryId) {
                $totalCapital = $investments->sum(function ($investment) {
                    $capital = $investment->capital ?? 0;
                    $exchangeRate = ExchangeRateHelper::getExchangeRateForInvestment($investment);
                    return $capital / $exchangeRate;
                });

                return [
                    'country' => Country::find($countryId)->name ?? 'Unknown',
                    'total_investment_usd' => $totalCapital,
                ];
            })->sortByDesc('total_investment_usd')->take(3);
        $stats = [];
        $indexRank = 1;
        foreach ($investmentsPerCountry as $investment) {
            $stats[] = Stat::make(
                $investment['country'],
                number_format($investment['total_investment_usd'], 2) . ' USD'
            )
            ->description('Total investments in ' . $investment['country'])
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chartColor('success')
            ->chart([2, 6, 1, 7, 9, 3, 5, 7, 1])
            ->color($this->getColorByIndex($indexRank))
            ->extraAttributes([
            'style' => 'color: white !important; background-color: ' . $this->getColorByIndex($indexRank) . ' !important;'

            ]);
            $indexRank++;
        }

        return $stats;
    }

    private function getColorByIndex(int $indexRank): string
    {
        $colors = [
            1 => '#DAA520',
            2 => '#C0C0C0', 
            3 => '#CE8946 ',
        ];

        return $colors[$indexRank] ?? 'bg-[#7D2B1D] text-white';
    }
}
