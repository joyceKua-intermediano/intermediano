<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvestmentResource\Pages;
use App\Filament\Resources\InvestmentResource\RelationManagers;
use App\Helpers\ExchangeRateHelper;
use App\Helpers\InvestmentHelper;
use App\Models\Bank;
use Filament\Forms\Components\Select;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Filament\Support\RawJs;

use App\Models\Investment;
use App\Models\Country;
use App\Models\Currency;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvestmentResource extends Resource
{
    protected static ?string $model = Investment::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Investments Overview';

    protected static ?string $label = 'Investments Portfolio';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('country_id')
                    ->label('Country')
                    ->options(Country::pluck('name', 'id'))
                    ->reactive()
                    ->required(),

                Select::make('bank_id')
                    ->label('Bank')
                    ->options(function ($get) {
                        $countryId = $get('country_id');
                        return $countryId ? Bank::where('country_id', $countryId)->pluck('bank_name', 'id') : [];
                    })
                    ->reactive()
                    ->required(),

                Select::make('currency_id')
                    ->label('Currency')
                    ->options(function ($get) {
                        $countryId = $get('country_id');
                        return $countryId ? Currency::where('country_id', $countryId)->pluck('currency_name', 'id') : [];
                    })
                    ->reactive()
                    ->required(),
                Forms\Components\TextInput::make('capital')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('rate_type')
                    ->label('Rate Type')
                    ->options([
                        'monthly' => 'Monthly Rate',
                        'annual' => 'Annual Rate',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('interest_rate')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('deposit_date')
                    ->required()
                    ->maxDate(now())
                    ->native(false)
                    ->displayFormat('d/m/Y'),

                Forms\Components\Select::make('withdrawal_period')
                    ->required()
                    ->options([
                        30 => '30 days',
                        60 => '60 days',
                        90 => '90 days',
                        120 => '120 days',
                        180 => '180 days',
                        365 => '365 days',
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Id')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('country.name')
                    ->label('Country')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('bank.bank_name')
                    ->label('Bank')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('currency.currency_name')
                    ->label('Currency')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('capital')
                    ->numeric()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('monthly_rate')
                    ->label('Monthly Interest Rate')
                    ->getStateUsing(function ($record) {
                        if ($record->rate_type === 'annual') {
                            $annualRate = $record->interest_rate / 100;
                            $monthlyRate = (pow(1 + $annualRate, 1 / 12)) - 1;
                            return round($monthlyRate * 100, 5) . '%';
                        }

                        return $record->interest_rate . '%';
                    }),

                Tables\Columns\TextColumn::make('deposit_date')
                    ->date()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('withdrawal_date')
                    ->label('Withdrawal Date')
                    ->getStateUsing(function ($record) {
                        $depositDate = Carbon::parse($record->deposit_date);
                        $withdrawalPeriod = $record->withdrawal_period ?? 0;

                        $withdrawalDate = $depositDate->addDays($withdrawalPeriod);

                        return $withdrawalDate->format('M j, Y');
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('monthlyInterest')
                    ->label('Monthly Interest')
                    ->getStateUsing(function ($record) {
                        return InvestmentHelper::convertToUSDOrDefault($record, function ($capital, $interestRate, $timeInMonths) {
                            $totalAmount = $capital * pow((1 + $interestRate), $timeInMonths);
                            $monthlyInterest = $totalAmount - $capital;
                            return $monthlyInterest / $timeInMonths;
                        });
                    }),
                Tables\Columns\TextColumn::make('totalInterest')
                    ->label('Total Interest')
                    ->getStateUsing(function ($record) {
                        return InvestmentHelper::convertToUSDOrDefault($record, function ($capital, $interestRate, $timeInMonths) {
                            $totalAmount = $capital * pow((1 + $interestRate), $timeInMonths);
                            $monthlyInterest = $totalAmount - $capital;
                            return $monthlyInterest;
                        });
                    }),

                Tables\Columns\TextColumn::make('totalAmount')
                    ->label('Total Amount')
                    ->getStateUsing(function ($record) {
                        return InvestmentHelper::convertToUSDOrDefault($record, function ($capital, $interestRate, $timeInMonths) {
                            return $capital * pow((1 + $interestRate), $timeInMonths);
                        });
                    }),

                Tables\Columns\TextColumn::make('netAmount')
                    ->label('Net Amount')
                    ->getStateUsing(function ($record) {
                        return InvestmentHelper::convertToUSDOrDefault($record, function ($capital, $rate, $months, $taxRate) {

                            $totalAmount = $capital * pow((1 + $rate), $months);
                            $taxAmount = ($totalAmount * $taxRate) / 100;
                            $netAmount = $totalAmount - ($rate * $taxAmount);
                            return $netAmount;
                        });
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                Tables\Actions\ButtonAction::make('Convert to USD')
                    ->action(function () {
                        Session::put('show_in_usd', !Session::get('show_in_usd', false));
                    })
                    ->label(function () {
                        return Session::get('show_in_usd', false) ? 'Convert to Original Currency' : 'Consolidate in USD';
                    })
                    ->color('primary'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListInvestments::route('/'),
            'create' => Pages\CreateInvestment::route('/create'),
            'view' => Pages\ViewInvestment::route('/{record}'),
            'edit' => Pages\EditInvestment::route('/{record}/edit'),
        ];
    }
    public static function getWidgets(): array
    {
        return [
            \App\Filament\Resources\InvestmentResource\Widgets\InvestmentWidget::class,
        ];
    }
}
