<?php

namespace App\Filament\Widgets;

use App\Helpers\ExchangeRateHelper;
use App\Models\Country;
use App\Models\Investment;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Filters\SelectFilter;

class CountryInvestmentRanking extends BaseWidget
{
    protected static ?int $sort = 1;

    public ?string $filter = null;

    public function __construct()
    {
        $this->filter = now()->year;
    }

    protected function getTableQuery(): Builder
    {

        return Investment::selectRaw('
                investments.country_id, 
                SUM(capital / 
                    CASE 
                        WHEN countries.use_real_time_conversion = 1 THEN IFNULL(countries.converted_currency_quota, 1)
                        ELSE IFNULL(currency.currency_quota, 1)
                    END
                ) as total_investment_usd
            ')
            ->join('countries', 'countries.id', '=', 'investments.country_id')
            ->join('currencies as currency', 'currency.id', '=', 'investments.currency_id')
            ->groupBy('investments.country_id')
            ->orderByDesc('total_investment_usd');
    }

 
    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('year')
            ->label('Filter by Year')
            ->default($this->filter)
            ->options(fn() => Investment::distinct()->pluck('year', 'year')->toArray())

        ];
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('country.name')
                ->label('Country'),
            Tables\Columns\TextColumn::make('total_investment_usd')
                ->label('Total Investment (USD)')
                ->formatStateUsing(fn($state) => number_format($state, 2)),
        ];
    }

    public function getTableRecordKey($record): string
    {
        return (string) $record->country_id;
    }
    protected function getAvailableYears(): array
    {
        return Investment::select('year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year')
        ->toArray();;

    }
}
