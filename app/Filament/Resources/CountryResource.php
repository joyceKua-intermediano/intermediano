<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\Pages;
use App\Filament\Resources\CountryResource\RelationManagers;
use App\Helpers\ExchangeRateHelper;
use App\Models\Country;
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

    protected static ?string $navigationGroup = 'System';

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
                    ->required()
                    ->label('Income Tax Rate (%)'),

                Forms\Components\Repeater::make('currencies')
                    ->relationship('currencies')
                    ->schema([
                        Forms\Components\TextInput::make('currency_name')
                            ->required()
                            ->label('Currency Name'),
                        Forms\Components\TextInput::make('currency_quota')
                            ->numeric()
                            ->required()
                            ->label('Currency Quota'),
                    ])
                    ->required()
                    ->label('Currencies'),


                Forms\Components\Repeater::make('banks')
                    ->relationship('banks')
                    ->schema([
                        Forms\Components\TextInput::make('bank_name')
                            ->required()
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
                        $firstCurrency = $record->currencies()->first();

                        return $record->use_real_time_conversion
                            ? ExchangeRateHelper::getExchangeRate('USD', $firstCurrency->currency_name,)
                            : $record->currencies()->where('currency_name', $firstCurrency->currency_name)->first()->currency_quota ?? $record->currency_name;
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
}
