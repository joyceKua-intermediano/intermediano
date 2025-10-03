<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProvisionReportsResource\Pages;
use App\Helpers\AccruedProvisionHelper;
use App\Models\Country;
use App\Models\Quotation;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProvisionReportsResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Provision Reports';
    protected static ?string $label = 'Provision Reports';
    protected static ?string $model = Quotation::class;
    protected static ?string $navigationGroup = 'Investments';
    protected static ?string $slug = 'provision-reports';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cluster_name')
                    ->label('Cluster')
                    ->searchable()
                    ->sortable(),

                // Tables\Columns\TextColumn::make('total_quotations')
                //     ->label('Total Quotations')
                //     ->sortable(),

                // Tables\Columns\TextColumn::make('total_accrued_provisions_local')
                //     ->label('Accrued (Local)')
                //     ->getStateUsing(function ($record) {
                //         $summary = AccruedProvisionHelper::getCountryProvisionSummary($record->cluster_name);
                //         $currency = $summary['currency']['name'] ?? 'USD';
                //         $amount = $summary['local']['accrued'] ?? 0;
                //         return $currency . ' ' . number_format($amount, 2);
                //     })
                //     ->sortable(),

                // Tables\Columns\TextColumn::make('total_paid_provisions_local')
                //     ->label('Paid (Local)')
                //     ->getStateUsing(function ($record) {
                //         $summary = AccruedProvisionHelper::getCountryProvisionSummary($record->cluster_name);
                //         $currency = $summary['currency']['name'] ?? 'USD';
                //         $amount = $summary['local']['paid'] ?? 0;
                //         return $currency . ' ' . number_format($amount, 2);
                //     })
                //     ->sortable(),

                Tables\Columns\TextColumn::make('net_provision_balance_local')
                    ->label('Accurued Balance (Local)')
                    ->getStateUsing(function ($record) {
                        $summary = AccruedProvisionHelper::getCountryProvisionSummary($record->cluster_name);
                        $currency = $summary['currency']['name'] ?? 'USD';
                        $amount = $summary['local']['balance'] ?? 0;
                        return $currency . ' ' . number_format($amount, 2);
                    })
                    ->sortable()
                    ->color(function ($record) {
                        $summary = AccruedProvisionHelper::getCountryProvisionSummary($record->cluster_name);
                        $balance = $summary['local']['balance'] ?? 0;
                        return $balance > 0 ? 'success' : ($balance < 0 ? 'danger' : 'warning');
                    }),

                Tables\Columns\TextColumn::make('total_accrued_provisions_usd')
                    ->label('Accrued Balance (USD)')
                    ->getStateUsing(function ($record) {
                        $summary = AccruedProvisionHelper::getCountryProvisionSummary($record->cluster_name);
                        $localAmount = $summary['local']['balance'] ?? 0;

                        $country = Country::find($record->country_id);
                        if ($country && $country->currencies && $country->currencies->isNotEmpty()) {
                            $exchangeRate = $country->currencies->first()->currency_quota;
                            if ($exchangeRate > 0) {
                                return $localAmount / $exchangeRate;
                            }
                        }

                        return $localAmount;
                    })
                    ->money('usd')
                    ->sortable(),
            ])
            ->defaultSort('cluster_name', 'asc')
            ->striped()
            ->paginated([25, 50, 100]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProvisionReports::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->selectRaw('
                CASE 
                    WHEN cluster_name = "IntermedianoColombiaSAS" THEN cluster_name
                    ELSE cluster_name
                END as id,
                CASE 
                    WHEN cluster_name = "IntermedianoColombiaSAS" THEN cluster_name
                    ELSE cluster_name
                END as cluster_name,
                COUNT(DISTINCT quotations.id) as total_quotations,
                quotations.country_id,
                NULL as is_integral
            ')
            ->where('is_payroll', 1)
            ->whereNotNull('cluster_name')
            ->whereNotLike('cluster_name', '%Partner%')
            ->groupBy('cluster_name', 'quotations.country_id')
            ->orderBy('cluster_name');
    }
}
