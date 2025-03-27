<?php

namespace App\Filament\Clusters\IntermedianoDoBrasilLtda\Resources;

use App\Exports\EmployeeExpensesExport;
use App\Filament\Clusters\IntermedianoDoBrasilLtda;
use App\Filament\Clusters\IntermedianoDoBrasilLtda\Resources\EmployeeExpensesResource\Pages;
use App\Filament\Clusters\IntermedianoDoBrasilLtda\Resources\EmployeeExpensesResource\RelationManagers;
use App\Models\Company;
use App\Models\EmployeeExpenses;
use App\Models\Contract;
use App\Models\Employee;
use App\Models\Quotation;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Filament\Forms\Components\Section;
use Illuminate\Support\HtmlString;
use Maatwebsite\Excel\Facades\Excel;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class EmployeeExpensesResource extends Resource
{
    protected static ?string $model = EmployeeExpenses::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = IntermedianoDoBrasilLtda::class;
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        $getUserTable = auth()->user()->getTable();
        $employeeCompanyId = Contract::where('employee_id', auth()->user()->id)->value('company_id');
        $employeeQuotationId = Contract::where('employee_id', auth()->user()->id)->value('quotation_id');
        $currencyName = Quotation::where('id', $employeeQuotationId)->value('currency_name');

        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->required()
                    ->relationship(name: 'employee', titleAttribute: 'name')
                    ->options(function () {
                        $customerId = auth()->user()->id;

                        return Employee::whereHas('contract', function ($query) {
                            $query->where('cluster_name', 'IntermedianoDoBrasilLtda');
                        })->pluck('name', 'id');
                    })->disabled(fn($record) => $record && $record?->created_by !== 'user'),
                Forms\Components\Select::make('company_id')
                    ->required()
                    ->relationship(name: 'company', titleAttribute: 'name')
                    ->options(function () {
                        $customerId = auth()->user()->id;

                        return Company::whereHas('contracts', function ($query) {
                            $query->where('cluster_name', 'IntermedianoDoBrasilLtda');
                        })->pluck('name', 'id');
                    })->disabled(fn($record) => $record && $record?->created_by !== 'user'),
                Forms\Components\TextInput::make('cost_center')
                    ->columnSpan(2)->disabled(fn($record) => $record && $record?->created_by !== 'customer'),

                Forms\Components\Select::make('type')
                    ->options([
                        'local' => 'Local',
                        'abroad' => 'Abroad',
                    ])
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::updateExpenseTotals($get, $set);
                    })
                    ->columnSpan(2)->disabled(fn($record) => $record && $record?->created_by !== 'customer'),

                Forms\Components\TextInput::make('currency_name')
                    ->default($currencyName)
                    ->columnSpan(1)
                    ->hidden(fn(Get $get) => !$get('type') || $get('type') === 'local')
                    ->disabled(fn($record) => $record?->created_by !== 'customer'),

                Repeater::make('expenses')
                    ->schema([
                        Forms\Components\TextInput::make('description')
                            ->required()
                            ->disabled(fn($record) => $record && $record?->created_by !== 'customer')
                            ->dehydrated(),

                        Forms\Components\DatePicker::make('date')
                            ->displayFormat('d-m-Y')
                            ->placeholder('dd-mm-yy')
                            ->native(false)
                            ->required()
                            ->disabled(fn($record) => $record && $record?->created_by !== 'customer')
                            ->dehydrated(),

                        Forms\Components\TextInput::make('amount')
                            ->numeric()

                            ->hidden(fn(Get $get) => $get('../../type') !== 'local')
                            ->disabled(fn($record) => $record && $record?->created_by !== 'customer')
                            ->dehydrated(),

                        Forms\Components\TextInput::make('federal_amount')
                            ->numeric()

                            ->hidden(fn(Get $get) => $get('../../type') !== 'local')
                            ->disabled(fn($record) => $record && $record?->created_by !== 'customer')
                            ->dehydrated(),

                        Forms\Components\TextInput::make('state_amount')
                            ->numeric()

                            ->hidden(fn(Get $get) => $get('../../type') !== 'local')
                            ->disabled(fn($record) => $record && $record?->created_by !== 'customer')
                            ->dehydrated(),

                        Forms\Components\TextInput::make('brl_include_taxes')
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::updateExpenseTotals($get, $set);
                            })
                            ->live(onBlur: true)
                            ->hidden(fn(Get $get) => $get('../../type') !== 'local')
                            ->disabled(fn($record) => $record && $record?->created_by !== 'customer')
                            ->dehydrated(),

                        Forms\Components\TextInput::make('usd')
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::updateExpenseTotals($get, $set);
                            })
                            ->live(onBlur: true)

                            ->numeric()
                            ->hidden(fn(Get $get) => $get('../../type') !== 'abroad')
                            ->disabled(fn($record) => $record && $record?->created_by !== 'customer')
                            ->dehydrated(),

                        Forms\Components\TextInput::make('exchange_rate')
                            ->numeric()
                            ->hidden(fn(Get $get) => $get('../../type') !== 'abroad')
                            ->disabled(fn($record) => $record && $record?->created_by !== 'customer')
                            ->dehydrated()
                            ->live(onBlur: true)

                            ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                $set('brl', ($get('usd') ?? 0) * $state);
                                self::updateExpenseTotals($get, $set);
                            }),

                        Forms\Components\TextInput::make('brl')
                            ->label('BRL')
                            ->disabled()
                            ->numeric()
                            ->hidden(fn(Get $get) => $get('../../type') !== 'abroad')
                            ->disabled(fn($record) => $record && $record?->created_by !== 'customer')
                            ->dehydrated(),

                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])->columnSpan(1)->hidden(fn($record) => $record?->created_by !== 'employee' && $getUserTable === 'users'),


                        Forms\Components\Textarea::make('comments')
                            ->columnSpan(3)->hidden(fn($record) => $record?->created_by !== 'employee' && $getUserTable === 'users'),
                    ])
                    ->columns(6)
                    ->itemLabel(function (array $state): ?HtmlString {
                        $description = $state['description'] ?? 'N/A';
                        $status = $state['status'] ?? 'Unknown';
                        $comments = $state['comments'] ?? '';

                        $badgeColor = match (strtolower($status)) {
                            'pending' => 'orange',
                            'approved' => 'green',
                            'rejected' => 'red',
                            default => 'gray',
                        };

                        return new HtmlString(
                            "<span>
                                <span style='font-weight: bold;'>{$description}</span>
                                <span style='color: {$badgeColor}; margin-left: 10px;'>[{$status}]</span>
                                <span style='color: gray; margin-left: 10px;'>Comments: {$comments}</span>
                            </span>"
                        );
                    })->defaultItems(1)
                    ->addActionLabel('Add another expense')
                    ->collapsible()
                    ->collapsed()
                    ->disableItemDeletion()
                    ->live()
                    ->addable(fn($record) =>  $record && $record->created_by === 'customer' ? 'Add another expense' : null) // Disable "Add another expense" for non-customers

                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::updateExpenseTotals($get, $set);
                    })
                    ->columnSpanFull(),

                Forms\Components\Hidden::make('company_id')
                    ->default(auth()->user()->id),
                Forms\Components\Hidden::make('created_by')
                    ->default('admin'),
                Forms\Components\Hidden::make('status')
                    ->default('approved'),
                Section::make('Totals')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('local_total')
                            ->label('Local Total (BRL)')
                            ->numeric()
                            ->readOnly()
                            ->prefix('R$')
                            ->hidden(fn(Get $get): bool => $get('type') !== 'local')
                            ->afterStateHydrated(function (Get $get, Set $set) {
                                self::updateExpenseTotals($get, $set);
                            }),

                        Forms\Components\TextInput::make('abroad_total')
                            ->label('Abroad Total (USD)')
                            ->numeric()
                            ->readOnly()
                            ->hidden(fn(Get $get): bool => $get('type') !== 'abroad')

                            ->prefix('$')
                            ->afterStateHydrated(function (Get $get, Set $set) {
                                self::updateExpenseTotals($get, $set);
                            }),


                    ]),
            ])->columns(8);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.name')
                    ->label('Employee')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Company')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date Created')
                    ->dateTime('d F Y')
                    ->sortable(),
                BadgeColumn::make('created_by')
                    ->sortable()
                    ->colors([
                        'primary' => fn($state) => $state === 'admin',
                        'success' => fn($state) => $state === 'employee',
                        'warning' => fn($state) => $state === 'customer',
                    ])
                    ->formatStateUsing(fn($state) => ucfirst($state)),

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
                // Add filters here if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                ExportAction::make('export')
                ->label('Export Expenses')
                ->action(function ($record) {
                    $employee = $record->employee->name ?? 'N/A';
                    $company = $record->company->name ?? 'N/A';
                    $expenses = $record->expenses;
                    $formattedDate = Carbon::parse($record->created_at)->format('m_Y');

                    $isLocal = $record->type === 'local' ? $record->currency_name : 'USD';
                    $formattedExpenses = array_map(function ($expense) use ($employee, $company, $record) {
                        return [
                            'Employee' => $employee,
                            'Company' => $company,
                            'Description' => $expense['description'] ?? 'N/A',
                            'Date' => $expense['date'] ?? 'N/A',
                            'Amount' => $expense['amount'] ?? 0,
                            'Federal Amount' => $expense['federal_amount'] ?? 0,
                            'State Amount' => $expense['state_amount'] ?? 0,
                            'BRL (Include Taxes)' => $expense['brl_include_taxes'] ?? 0,
                            'USD' => $expense['usd'] ?? 0,
                            'Exchange Rate' => $expense['exchange_rate'] ?? 'N/A',
                            'BRL' => $expense['brl'] ?? 0,
                            'Status' => $record->status ==='approved' ? 'Approved' : $expense['status'],
                            'Comments' => $expense['comments'] ?? '',
                            // 'Local Total' => $expense['local_total'] ?? 0,
                            // 'Abroad Total' => $expense['abroad_total'] ?? 0,
                            // 'Grand Total' => $expense['grand_total'] ?? 0,
                        ];
                    }, $expenses);
                    
                    return Excel::download(new EmployeeExpensesExport($formattedExpenses),  'Expenses_'. $formattedDate .'_' . $isLocal . '_'. $employee.'.xlsx');
                    
                })
            
            ]);
    }


    public static function updateExpenseTotals(Get $get, Set $set): void
    {
        $expenses = $get('expenses') ?? [];
        $type = $get('type');

        $localTotal = 0;
        $abroadTotal = 0;

        foreach ($expenses as $expense) {
            if ($type === 'local') {
                // $localTotal += (float)($expense['amount'] ?? 0);
                // $localTotal += (float)($expense['federal_amount'] ?? 0);
                // $localTotal += (float)($expense['state_amount'] ?? 0);
                $localTotal += (float)($expense['brl_include_taxes'] ?? 0);
            } else {
                $abroadTotal += (float)($expense['usd'] ?? 0);
            }
        }

        $set('local_total', number_format($localTotal, 2, '.', ''));
        $set('abroad_total', number_format($abroadTotal, 2, '.', ''));
        $set('grand_total', number_format($type === 'local' ? $localTotal : $abroadTotal, 2, '.', ''));
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployeeExpenses::route('/'),
            'create' => Pages\CreateEmployeeExpenses::route('/create'),
            'edit' => Pages\EditEmployeeExpenses::route('/{record}/edit'),
        ];
    }
}
