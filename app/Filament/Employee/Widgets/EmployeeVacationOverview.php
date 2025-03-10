<?php

namespace App\Filament\Employee\Widgets;

use App\Helpers\VacationBalanceHelper;
use App\Models\Contract;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\Auth;

class EmployeeVacationOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();
        $contract = Contract::where('employee_id', $user->id)->where('contract_type', 'employee')->first();
        if (!$contract) {
            return [
                Card::make('Accrued Vacation', 'No Contract Found')
                    ->color('danger')
                    ->description('You need an active contract.')
                    ->icon('heroicon-o-exclamation-circle'),
            ];
        }
        $startDate = Carbon::parse($contract->start_date);

        $accruedBalance = VacationBalanceHelper::getVacationBalance();

        $totalVacationTaken = VacationBalanceHelper::getTotalVacationTaken();
        $accruedVacationDays = VacationBalanceHelper::getAccruedVacation();

        return [
            Card::make('Contract Start Date', $startDate->format('M d, Y'))
                ->color('primary')
                ->description('The date your contract started.')
                ->icon('heroicon-o-calendar')
                ->chart([3, 7, 9, 15, 12]), // Example chart data

            Card::make('Accrued Vacation Days', round($accruedVacationDays, 2))
                ->color('info')
                ->description('Vacation days accrued based on your work.')
                ->icon('heroicon-o-sun')
                ->chartColor('success')
                ->chart([2, 4, 5, 7, 10]),
                Card::make('Vacation Taken', round($totalVacationTaken, 2))
                ->color('warning')
                ->description('Total vacation days you have taken.')
                ->icon('heroicon-o-paper-airplane')
                ->chartColor('warning')
                ->chart([1, 2, 3, 4, 5]), 
                Card::make('Vacation Balance',  round($accruedBalance, 2))
                ->color('success')
                ->description('Total remaining balance vacation days.')
                ->icon('heroicon-o-clipboard-document-check')
                ->chartColor('success')
                ->chart([1, 2, 3, 4, 5]), 
        ];
    }
}
