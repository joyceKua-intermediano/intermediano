<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsultantResource\Pages;
use App\Filament\Resources\ConsultantResource\RelationManagers;
use App\Models\Company;
use App\Models\Consultant;
use App\Models\IntermedianoCompany;
use App\Models\Partner;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConsultantResource extends Resource
{
    protected static ?string $model = Consultant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Administration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('name')
                    ->required(),
                Forms\Components\Select::make('country_id')
                    ->label('Nationality')
                    ->relationship('country', 'name')
                    ->required(),

                TextInput::make('mobile_number'),
                TextInput::make('email')
                    ->email(),

                TextInput::make('address'),

                Forms\Components\Select::make('employeer')
                    ->label('Employeer')
                    ->options(function () {
                        // Fetch data from both models
                        $companies = IntermedianoCompany::pluck('name', 'id')->mapWithKeys(fn($name, $id) => ["company: $name" => "Company: $name"]);
                        $partners = Partner::pluck('name', 'id')->mapWithKeys(fn($name, $id) => ["partner: $name" => "Partner: $name"]);

                        return $companies->merge($partners)->toArray();
                    })
                    ->searchable()
                    ->placeholder('Select an Employeer'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Id')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('mobile_number')
                    ->label('Mobile number')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('address')
                    ->label('Address')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('country.name')
                    ->label('Nationality')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('employeer')
                    ->label('Employeer')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
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
            'index' => Pages\ListConsultants::route('/'),
            'create' => Pages\CreateConsultant::route('/create'),
            'edit' => Pages\EditConsultant::route('/{record}/edit'),
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
