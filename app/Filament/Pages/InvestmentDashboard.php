<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CountryInvestmentRanking;
use App\Filament\Widgets\DashboardChart;
use App\Filament\Widgets\MonthlyCountryInterestChart;
use App\Filament\Widgets\StatsDashboard;
use App\Filament\Widgets\YearLineChart;
use App\Filament\Widgets\YearlyCountryInterestChart;
use Filament\Pages\Page;

class InvestmentDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationGroup = 'Investments';
    protected static ?string $navigationLabel = 'Investments Graphics';


    protected static string $view = 'filament.pages.investment-dashboard';
 
    protected function getHeaderWidgets(): array
    {
        return [
            StatsDashboard::class,
            CountryInvestmentRanking::class,
            DashboardChart::class,
            MonthlyCountryInterestChart::class,
            YearLineChart::class,
            YearlyCountryInterestChart::class,
        ];
    }
}
