<?php

namespace App\Filament\Employee\Resources;

use App\Filament\Employee\Resources\VacationRequestResource\Pages;
use App\Filament\Employee\Resources\VacationRequestResource\RelationManagers;
use App\Filament\Employee\Widgets\EmployeeVacationOverview;
use App\Helpers\VacationBalanceHelper;
use App\Models\Contract;
use App\Models\VacationRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;

class VacationRequestResource extends Resource
{
    protected static ?string $model = VacationRequest::class;
    protected static ?string $label = 'Accured Vacation';
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $employeeCompanyId = Contract::where('employee_id', auth()->user()->id)->value('company_id');

        return $form
            ->schema([
                DatePicker::make('start_date')->required(),
                DatePicker::make('end_date')->required(),
                TextInput::make('number_of_days')->required()->numeric()->maxValue(round(static::getVacationBalance(), 2)),
                Forms\Components\Hidden::make('employee_id')
                    ->default(auth()->user()->id),
                Forms\Components\Hidden::make('company_id')
                    ->default($employeeCompanyId),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('start_date')->sortable(),
                TextColumn::make('end_date')->sortable(),
                TextColumn::make('number_of_days')->sortable(),
                BadgeColumn::make('status')
                    ->sortable()
                    ->colors([
                        'primary' => fn($state) => $state === 'pending',
                        'success' => fn($state) => $state === 'approved',
                        'danger' => fn($state) => $state === 'rejected',
                    ])
                    ->formatStateUsing(fn($state) => ucfirst($state)),


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->visible(fn($record) => $record->status !== 'approved'),
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
            'index' => Pages\ListVacationRequests::route('/'),
            'create' => Pages\CreateVacationRequest::route('/create'),
            'edit' => Pages\EditVacationRequest::route('/{record}/edit'),
        ];
    }

    public static function getVacationBalance(): int
    {
        $vacationBalance = VacationBalanceHelper::getVacationBalance();
        return $vacationBalance;
    }

    public static function getEloquentQuery(): Builder
    {
        $employeeId = auth()->user()->id;
        $employeeVacationRequest = VacationRequest::where('employee_id',  $employeeId);
        return $employeeVacationRequest;
    }
}
