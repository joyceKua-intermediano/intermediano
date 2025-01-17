<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryAnnualSetupResource\Pages;
use App\Filament\Resources\CountryAnnualSetupResource\RelationManagers;
use App\Models\Country;
use App\Models\CountryAnnualSetup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CountryAnnualSetupResource extends Resource
{
    protected static ?string $model = CountryAnnualSetup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'Countries Annual Setup';

    protected static ?string $navigationParentItem = 'Countries Overviews';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('country_id')
                    ->label('Country')
                    ->options(Country::pluck('name', 'id'))
                    ->reactive()
                    ->required(),

                Forms\Components\TextInput::make('year')
                    ->label('Year')
                    ->required(),
                Forms\Components\TextInput::make('uvt_amount')
                    ->label('UVT Amount')
                    ->mask(RawJs::make(<<<'JS'
                    $money($input, '.', ',', 2)
                    JS))
                    ->afterStateUpdated(function ($component, $state) {
                        $cleanedState = preg_replace('/[^0-9\.]+/', '', $state);
                        $component->state($cleanedState);
                    })
                    ->required(),
                Forms\Components\TextInput::make('capped_amount')
                    ->label('Capped Amount')
                    ->mask(RawJs::make(<<<'JS'
                    $money($input, '.', ',', 2)
                    JS))
                    ->afterStateUpdated(function ($component, $state) {
                        $cleanedState = preg_replace('/[^0-9\.]+/', '', $state);

                        $component->state($cleanedState);
                    })
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('country.name')
                ->label('Country')
                ->sortable()
                ->searchable(),

                Tables\Columns\TextColumn::make('year')
                ->label('Year')
                ->sortable()
                ->searchable(),

                Tables\Columns\TextColumn::make('uvt_amount')
                ->label('UVT Amount')
                ->sortable()
                ->searchable(),
                
                Tables\Columns\TextColumn::make('capped_amount')
                ->label('Capped Amount')
                ->sortable()
                ->searchable(),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('name')->relationship('country', 'name')


            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListCountryAnnualSetups::route('/'),
            'create' => Pages\CreateCountryAnnualSetup::route('/create'),
            'edit' => Pages\EditCountryAnnualSetup::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
