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

        $getInterestRate = function ($investment) {
            if ($investment->rate_type === 'annual') {
                $annualRate = $investment->interest_rate / 100;
                return pow(1 + $annualRate, 1 / 12) - 1;
            } else {
                return $investment->interest_rate / 100;
            }
        };

        $totalCapitalUsd = Investment::all()->sum(function ($investment) {
            $capital = $investment->capital ?? 0;
            $exchangeRate = ExchangeRateHelper::getExchangeRateForInvestment($investment);
            return $capital / $exchangeRate;
        });

        $totalInterestUsd = Investment::all()->sum(function ($investment) use ($getInterestRate) {
            $capital = $investment->capital ?? 0;
            $interestRate = $getInterestRate($investment);
            $exchangeRate = ExchangeRateHelper::getExchangeRateForInvestment($investment);
            $daysInMonth = 30;
            $timeInMonths = ($investment->withdrawal_period ?? 0) / $daysInMonth;

            $totalAmount = $capital * pow((1 + $interestRate), $timeInMonths);

            $monthlyInterest = $totalAmount - $capital;

            return $monthlyInterest / $exchangeRate;
        });

        $monthlyInterestInUsd = Investment::all()->sum(function ($investment) use ($getInterestRate) {
            $capital = $investment->capital ?? 0;
            $interestRate = $getInterestRate($investment);
            $exchangeRate = ExchangeRateHelper::getExchangeRateForInvestment($investment);
            $daysInMonth = 30;
            $timeInMonths = ($investment->withdrawal_period ?? 0) / $daysInMonth;

            $totalAmount = $capital * pow((1 + $interestRate), $timeInMonths);

            $totalInterest = $totalAmount - $capital;

            $monthlyInterest = $totalInterest / $timeInMonths;

            return $monthlyInterest / $exchangeRate;
        });

        // totalNetAmountUsd is not currently used but could be utilized if requested.
        $totalNetAmountUsd = Investment::all()->sum(function ($investment) use ($getInterestRate) {
            $capital = $investment->capital ?? 0;
            $interestRate = $getInterestRate($investment);
            $exchangeRate = ExchangeRateHelper::getExchangeRateForInvestment($investment);
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

            Stat::make('Monthly Interest (USD)', '$' . number_format($monthlyInterestInUsd, 2))
                ->description('Monthly Interest across all investments, excluding the withdrawal period')
                ->icon('heroicon-o-calculator')
                ->color('info'),
        ];
    }
}
