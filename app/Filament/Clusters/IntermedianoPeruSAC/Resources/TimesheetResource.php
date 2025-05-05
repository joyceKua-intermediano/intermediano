<?php

namespace App\Filament\Clusters\IntermedianoPeruSAC\Resources;

use App\Filament\Clusters\IntermedianoPeruSAC;
use App\Filament\Clusters\IntermedianoPeruSAC\Resources\TimesheetResource\Pages;
use App\Filament\Clusters\IntermedianoPeruSAC\Resources\TimesheetResource\RelationManagers;
use App\Models\MonthlyTimesheet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Carbon\Carbon;
use App\Exports\TimesheetExport;
use Maatwebsite\Excel\Facades\Excel;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use Illuminate\Database\Eloquent\Builder;

class TimesheetResource extends Resource
{
    protected static ?string $model = MonthlyTimesheet::class;

    protected static ?int $navigationSort = 5;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = IntermedianoPeruSAC::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Month Selection')
                    ->schema([
                        Forms\Components\Select::make('year')
                            ->options(function () {
                                $years = range(now()->year - 1, now()->year + 1);
                                return array_combine($years, $years);
                            })

                            ->disabled()->dehydrated(),

                        Forms\Components\Select::make('month')
                            ->options([
                                1 => 'January',
                                2 => 'February',
                                3 => 'March',
                                4 => 'April',
                                5 => 'May',
                                6 => 'June',
                                7 => 'July',
                                8 => 'August',
                                9 => 'September',
                                10 => 'October',
                                11 => 'November',
                                12 => 'December'
                            ])
                            ->disabled()->dehydrated(),

                    ])
                    ->columns(2),

                Forms\Components\Section::make('Daily Hours')
                    ->schema([
                        Forms\Components\Grid::make(7)
                            ->schema(function (\Filament\Forms\Get $get) {
                                $year = $get('year') ?? now()->year;
                                $month = $get('month') ?? now()->month;

                                $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;

                                return collect(range(1, $daysInMonth))->map(function ($day) {
                                    return Forms\Components\TextInput::make("days.{$day}")
                                        ->label($day)
                                        ->numeric()
                                        ->minValue(0)
                                        ->maxValue(24)
                                        ->step(0.25)
                                        ->disabled()->dehydrated()

                                        ->suffix('hrs');
                                })->toArray();
                            }),
                    ]),

                Forms\Components\Section::make('Summary')
                    ->schema([
                        Forms\Components\TextInput::make('total_hours')
                            ->label('Total Monthly Hours')
                            ->numeric()
                            ->disabled()
                            ->dehydrated()
                            ->afterStateHydrated(function ($component, $state, $record) {
                                if (!$state && $record) {
                                    $component->state(array_sum($record->days ?? []));
                                }
                            })->columnSpan(1),
                        Forms\Components\Select::make('status')
                            ->options([
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])->columnSpan(1),

                        Forms\Components\Textarea::make('comment')
                            ->columnSpan(2),
                    ])->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('month_year')
                    ->sortable(['year', 'month'])
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
                        2 => 'February',
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

    public static function canCreate(): bool
    {
        return false;
    }
    public static function canEdit($record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTimesheets::route('/'),
            'create' => Pages\CreateTimesheet::route('/create'),
            'edit' => Pages\EditTimesheet::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        $contractCluster = MonthlyTimesheet::whereHas('employee', function ($query) {
            $query->where('company', 'IntermedianoPeruSAC');
        });
        return $contractCluster;
    }
}
