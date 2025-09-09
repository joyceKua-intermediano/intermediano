<?php

namespace App\Filament\Resources\InvestmentResource\Widgets;

use App\Models\Investment;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class ExpiringInvestmentsWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 'full'; // full screen

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query($this->getQuery())
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('country.name')
                    ->label('Country')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank.bank_name')
                    ->label('Bank')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('capital')
                    ->label('Capital (Local Currency)'),

                Tables\Columns\TextColumn::make('maturity_date')
                    ->label('Maturity Date')
                    ->date()
                    ->getStateUsing(fn($record) => Carbon::parse($record->deposit_date)->addDays($record->withdrawal_period)),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->getStateUsing(function ($record) {
                        $maturity = Carbon::parse($record->deposit_date)->addDays($record->withdrawal_period);
                        return $maturity->isPast() ? 'Expired' : 'Active';
                    })
                    ->badge()
                    ->color(fn($state) => $state === 'Expired' ? 'danger' : 'success'),
            ]);
    }

    private function getQuery(): Builder
    {
        $today = Carbon::today();
        $next30Days = Carbon::today()->addDays(30);

        return Investment::query()
            ->whereRaw("DATE_ADD(deposit_date, INTERVAL withdrawal_period DAY) <= ?", [$next30Days])

            ->orderByRaw("
                (DATE_ADD(deposit_date, INTERVAL withdrawal_period DAY)) ASC
            ")
            ->limit(10); // adjust how many you want to show
    }
}
