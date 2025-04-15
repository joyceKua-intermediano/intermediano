<?php

namespace App\Filament\Employee\Resources;

use App\Filament\Employee\Resources\TimesheetResource\Pages;
use App\Filament\Employee\Resources\TimesheetResource\RelationManagers;
use App\Models\Contract;
use App\Models\MonthlyTimesheet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;
use App\Exports\TimesheetExport;
use Illuminate\Support\HtmlString;
use Maatwebsite\Excel\Facades\Excel;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class TimesheetResource extends Resource
{
    protected static ?string $model = MonthlyTimesheet::class;
    protected static ?string $label = 'Timesheet';
    protected static ?int $navigationSort = 6;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $contractDetails = Contract::where('employee_id', auth()->user()->id)
            ->whereIn('contract_type', ['employee', 'customer', 'partner'])
            ->orderByRaw("FIELD(contract_type, 'employee', 'customer', 'partner')")
            ->first();
        return $form
            ->schema([
                Forms\Components\Section::make('Month Selection')
                    ->schema([
                        Forms\Components\Hidden::make('employee_id')
                            ->default(auth()->user()->id),
                        Forms\Components\Hidden::make('company_id')
                            ->default($contractDetails->company_id),
                        Forms\Components\Select::make('year')
                            ->options(function () {
                                $years = range(now()->year - 1, now()->year + 1);
                                return array_combine($years, $years);
                            })
                            ->default(now()->year)
                            ->live() // Add live() to make it reactive
                            ->required(),

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
                            ->default(now()->month)
                            ->live() // Add live() to make it reactive
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Daily Hours')
                    ->schema([
                        Forms\Components\Grid::make(7)
                            ->schema(function (\Filament\Forms\Get $get) {
                                $year = $get('year') ?? now()->year;
                                $month = $get('month') ?? now()->month;

                                // Get the number of days in the selected month/year
                                $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;

                                return collect(range(1, $daysInMonth))->map(function ($day) {
                                    return Forms\Components\TextInput::make("days.{$day}")
                                        ->label($day)
                                        ->numeric()
                                        ->minValue(0)
                                        ->maxValue(24)
                                        ->step(0.25)
                                        ->suffix('hrs');
                                })->toArray();
                            }),
                    ]),

                // Forms\Components\Section::make('Summary')
                //     ->schema([
                //         Forms\Components\TextInput::make('total_hours')
                //             ->label('Total Monthly Hours')
                //             ->numeric()
                //             ->disabled()
                //             ->dehydrated()
                //             ->afterStateHydrated(function ($component, $state, $record) {
                //                 if (!$state && $record) {
                //                     $component->state(array_sum($record->days ?? []));
                //                 }
                //             }),
                //     ]),
                Forms\Components\Section::make(function (array $state): ?HtmlString {
                    $status = $state['status'] ?? 'Unknown';

                    $badgeColor = match (strtolower($status)) {
                        'approved' => 'green',
                        'pending' => 'orange',
                        'rejected' => 'red',
                        default => 'gray',
                    };

                    return new HtmlString(
                        "<span>
                            <span style='color: gray; margin-left: 10px;'>Review Status:</span>

                            <span style='color: {$badgeColor}; margin-left: 10px;'> [{$status}]</span>
                        </span>"
                    );
                })
                    ->schema([
                        Forms\Components\Hidden::make('status')
                            ->default('pending')
                            ->dehydrateStateUsing(fn($state) => 'pending'),

                        Forms\Components\Textarea::make('comment')
                            ->label('Reviewer Comments')
                            ->disabled()
                            ->dehydrated()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->visible(fn($record) => $record && ($record->status !== 'pending' || $record->comments)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
    public static function canEdit($record): bool
    {
        return $record->status !== 'approved';
    }

    public static function getEloquentQuery(): Builder
    {
        $employeeId = auth()->user()->id;
        $getEmployeeExpenses = MonthlyTimesheet::where('employee_id', $employeeId);
        return $getEmployeeExpenses;
    }
}
