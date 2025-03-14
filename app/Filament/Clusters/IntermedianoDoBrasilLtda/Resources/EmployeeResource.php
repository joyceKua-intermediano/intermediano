<?php

namespace App\Filament\Clusters\IntermedianoDoBrasilLtda\Resources;

use App\Filament\Clusters\IntermedianoDoBrasilLtda;
use App\Filament\Clusters\IntermedianoDoBrasilLtda\Resources\EmployeeResource\Pages;
use App\Filament\Clusters\IntermedianoDoBrasilLtda\Resources\EmployeeResource\RelationManagers;
use App\Models\Consultant;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = IntermedianoDoBrasilLtda::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('name')
                    ->label('Consultant Name')
                    ->options(Consultant::all()->pluck('name', 'name'))
                    ->required()
                    ->searchable(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->dehydrated(fn($state) => filled($state))
                    ->visibleOn('create'),

                Forms\Components\Hidden::make('company')
                    ->default(self::getClusterName())
                    ->label(self::getClusterName()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vacation_accrued')
                    ->label('Accrued Vacation')
                    ->getStateUsing(fn($record) => round($record->getAccruedVacation(), 2)),
                Tables\Columns\TextColumn::make('vacation_taken')
                    ->label('Vacation Taken')
                    ->getStateUsing(fn($record) => round($record->getTakenVacation(), 2)),
                Tables\Columns\TextColumn::make('vacation_balance')
                    ->getStateUsing(fn($record) => round($record->getVacationBalance(), 2))
                    ->label('Vacation Balance'),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Filters\TrashedFilter::make(),
                Filter::make('cluster_match')
                ->label('Company Name')
                ->query(fn(Builder $query): Builder => $query->where('company', self::getClusterName()))
                ->default(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    protected static function getClusterName(): string
    {
        return class_basename(self::$cluster);
    }
}
