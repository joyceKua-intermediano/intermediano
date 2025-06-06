<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\Pages;
use App\Filament\Resources\CountryResource\RelationManagers;
use App\Helpers\ExchangeRateHelper;
use App\Models\Country;
use App\Models\Currency;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    protected static ?string $navigationGroup = 'Investments';

    protected static ?string $label = 'Countries Overview';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('Country Name'),

                Forms\Components\TextInput::make('income_tax_rate')
                    ->numeric()
                    ->label('Income Tax Rate (%)'),

                Forms\Components\Repeater::make('currencies')
                    ->relationship('currencies')
                    ->schema([
                        Forms\Components\TextInput::make('currency_name')
                            ->label('Currency Name'),
                        Forms\Components\TextInput::make('currency_quota')
                            ->numeric()
                            ->label('Currency Quota'),
                    ])
                    ->label('Currencies'),


                Forms\Components\Repeater::make('banks')
                    ->relationship('banks')
                    ->schema([
                        Forms\Components\TextInput::make('bank_name')
                            ->label('Bank Name'),
                    ])
                    ->label('Banks'),
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

                Tables\Columns\TextColumn::make('name')
                    ->label('Country')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('currencies.currency_name')
                    ->label('Currency')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('banks.bank_name')
                    ->label('Bank Name')
                    ->sortable()
                    ->searchable(),


                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created On')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // use realtime conversion column place in the Country model  due to filament limitation for updating  database using ToggleColumn
                Tables\Columns\ToggleColumn::make('use_real_time_conversion')
                    ->label('Real-Time Conversion')
                    ->sortable()
                    ->toggleable()
                    ->action(function (Country $record) {
                        $record->update([
                            'use_real_time_conversion' => !$record->use_real_time_conversion,
                        ]);
                    }),
                Tables\Columns\TextColumn::make('exchange_rate')
                    ->label('Exchange Rate')
                    ->getStateUsing(function (Country $record) {
                        $currencies = $record->currencies()->get();
                        $exchangeRates = [];

                        if ($record->use_real_time_conversion) {
                            foreach ($currencies as $currency) {
                                $exchangeRates[] = $currency->converted_currency_quota;
                            }
                        } else {
                            foreach ($currencies as $currency) {
                                $exchangeRates[] = $currency->currency_quota;
                            }
                        }
                        return $exchangeRates;
                    }),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Add any necessary filters
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

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
            'index' => Pages\ListCountries::route('/'),
            'create' => Pages\CreateCountry::route('/create'),
            'view' => Pages\ViewCountry::route('/{record}'),
            'edit' => Pages\EditCountry::route('/{record}/edit'),
        ];
    }
    public static function canAccess(): bool
    {
        return auth()->user()->can("Show Country");
    }
}
