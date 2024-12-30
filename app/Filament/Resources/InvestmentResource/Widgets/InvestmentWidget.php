<?php

namespace App\Filament\Resources\InvestmentResource\Widgets;

use App\Models\Investment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Helpers\ExchangeRateHelper;

class InvestmentWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $getExchangeRate = function ($investment) {
            if ($investment->country->use_real_time_conversion) {
                return $investment->country->converted_currency_quota;
                // return ExchangeRateHelper::getExchangeRate('USD', $investment->currency->currency_name);
            } else {
                return $investment->currency->currency_quota ?? 1;
            }
        };

        $getInterestRate = function ($investment) {
            if ($investment->rate_type === 'annual') {
                $annualRate = $investment->interest_rate / 100;
                return pow(1 + $annualRate, 1 / 12) - 1;
            } else {
                return $investment->interest_rate / 100;
            }
        };

        $totalCapitalUsd = Investment::all()->sum(function ($investment) use ($getExchangeRate) {
            $capital = $investment->capital ?? 0;
            $exchangeRate = $getExchangeRate($investment);
            return $capital / $exchangeRate;
        });

        $totalInterestUsd = Investment::all()->sum(function ($investment) use ($getExchangeRate, $getInterestRate) {
            $capital = $investment->capital ?? 0;
            $interestRate = $getInterestRate($investment);
            $exchangeRate = $getExchangeRate($investment);
            $daysInMonth = 30;
            $timeInMonths = ($investment->withdrawal_period ?? 0) / $daysInMonth;

            $totalAmount = $capital * pow((1 + $interestRate), $timeInMonths);

            $monthlyInterest = $totalAmount - $capital;

            return $monthlyInterest / $exchangeRate;
        });

        $totalNetAmountUsd = Investment::all()->sum(function ($investment) use ($getExchangeRate, $getInterestRate) {
            $capital = $investment->capital ?? 0;
            $interestRate = $getInterestRate($investment);
            $exchangeRate = $getExchangeRate($investment);
            $daysInMonth = 30;
            $timeInMonths = ($investment->withdrawal_period ?? 0) / $daysInMonth;

            $totalAmount = $capital * pow((1 + $interestRate), $timeInMonths);

            return $totalAmount / $exchangeRate;
        });

        return [
            Stat::make('Total Capital (USD)', '$' . number_format($totalCapitalUsd, 2))
                ->description('Sum of all investments in USD')
                ->icon('heroicon-o-currency-dollar')
                ->color('success'),

            Stat::make('Total Interest (USD)', '$' . number_format($totalInterestUsd, 2))
                ->description('Total compounded interest across all investments')
                ->icon('heroicon-o-arrow-trending-up')
                ->color('primary'),

            Stat::make('Total Net Amount (USD)', '$' . number_format($totalNetAmountUsd, 2))
                ->description('Net amount in USD, including capital and interest')
                ->icon('heroicon-o-calculator')
                ->color('info'),
        ];
    }
}
