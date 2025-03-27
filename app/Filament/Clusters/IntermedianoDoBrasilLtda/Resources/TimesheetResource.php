<?php

namespace App\Filament\Clusters\IntermedianoDoBrasilLtda\Resources;

use App\Filament\Clusters\IntermedianoDoBrasilLtda;
use App\Filament\Clusters\IntermedianoDoBrasilLtda\Resources\TimesheetResource\Pages;
use App\Filament\Clusters\IntermedianoDoBrasilLtda\Resources\TimesheetResource\RelationManagers;
use App\Models\MonthlyTimesheet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;
use App\Exports\TimesheetExport;
use Maatwebsite\Excel\Facades\Excel;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class TimesheetResource extends Resource
{
    protected static ?string $model = MonthlyTimesheet::class;
    protected static ?string $label = 'Employee Timesheet';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = IntermedianoDoBrasilLtda::class;

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
                Tables\Columns\TextColumn::make('employee.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('month_year')
                    ->sortable(['year', 'month']) // Specify the columns for sorting
                    ->label('Period')
                    ->getStateUsing(
                        fn($record) =>
                        $record->year && $record->month
                            ? \Carbon\Carbon::create($record->year, $record->month)->format('F Y')
                            : 'Invalid Date'
                    ),
                Tables\Columns\TextColumn::make('total_hours')
                    ->sortable()
                    ->label('Total Hours')
                    ->formatStateUsing(fn($state) => number_format($state, 2) . ' hrs'),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->dateTime(),
                Tables\Columns\BadgeColumn::make('status')
                    ->sortable()
                    ->colors([
                        'primary' => fn($state) => $state === 'pending',
                        'success' => fn($state) => $state === 'approved',
                        'danger' => fn($state) => $state === 'rejected',
                    ])
                    ->formatStateUsing(fn($state) => ucfirst($state)),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('month')
                    ->options([
                        1 => 'January',
                        2 => 'February', /* ... */
                        12 => 'December'
                    ]),
                Tables\Filters\SelectFilter::make('year')
                    ->options(function () {
                        $years = range(now()->year - 1, now()->year + 1);
                        return array_combine($years, $years);
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                ExportAction::make('export')
                    ->label('Export Timesheet')
                    ->action(function ($record) {
                        return Excel::download(
                            new TimesheetExport($record),
                            "timesheet-" . \Carbon\Carbon::create($record->year, $record->month)->format('F Y') . "-{$record->employee->name}.xlsx"
                        );
                    })
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
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
            'index' => Pages\ListTimesheets::route('/'),
            'create' => Pages\CreateTimesheet::route('/create'),
            'edit' => Pages\EditTimesheet::route('/{record}/edit'),
        ];
    }
    public static function canCreate(): bool
    {
        return false;
    }
    public static function canEdit($record): bool
    {
        return false;
    }
}
