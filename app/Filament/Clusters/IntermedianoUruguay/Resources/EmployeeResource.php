<?php

namespace App\Filament\Clusters\IntermedianoUruguay\Resources;

use App\Filament\Clusters\IntermedianoUruguay;
use App\Filament\Clusters\IntermedianoUruguay\Resources\EmployeeResource\Pages;
use App\Filament\Clusters\IntermedianoUruguay\Resources\EmployeeResource\RelationManagers;
use App\Models\Consultant;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = IntermedianoUruguay::class;

    protected static ?int $navigationSort = 7;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('name')
                    ->label('Consultant Name')
                    ->options(Consultant::pluck('name', 'name'))

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
                // Filter::make('cluster_match')
                //     ->label('Company Name')
                //     ->query(fn(Builder $query): Builder => $query->where('company', self::getClusterName()))
                //     ->default(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('Bank Details')
                    ->modal()
                    ->icon('heroicon-o-banknotes')
                    ->color('primary')
                    ->modalSubmitAction(false)
                    ->modalWidth('sm')
                    ->modalCancelAction(fn($action) => $action->label('Close'))
                    ->modalContent(fn(Employee $record): View => view(
                        'filament.employee.modal.bank-details',
                        ['record' => $record],
                    )),
                Action::make('Vacation Details')
                    ->modal()
                    ->icon('heroicon-o-sun')
                    ->color('secondary')
                    ->modalSubmitAction(false)
                    ->modalWidth('sm')
                    ->modalCancelAction(fn($action) => $action->label('Close'))
                    ->modalContent(fn(Employee $record): View => view(
                        'filament.employee.modal.vacation-details',
                        ['record' => $record],
                    )),
                Action::make('Personal Informations')
                    ->modal()
                    ->icon('heroicon-o-user-circle')
                    ->color('info')
                    ->modalSubmitAction(false)
                    ->modalCancelAction(fn($action) => $action->label('Close'))
                    ->modalContent(fn(Employee $record): View => view(
                        'filament.employee.modal.personal-details',
                        ['record' => $record],
                    )),
                Action::make('Documents')
                    ->modal()
                    ->icon('heroicon-o-document-text')
                    ->color('warning')
                    ->modalSubmitAction(false)
                    ->modalCancelAction(fn($action) => $action->label('Close'))
                    ->modalContent(fn(Employee $record): View => view(
                        'filament.employee.modal.document-details',
                        ['record' => $record],
                    ))
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
        $contractCluster = Employee::where('company', self::getClusterName());
        return $contractCluster;
    }

    protected static function getClusterName(): string
    {
        return class_basename(self::$cluster);
    }
}
