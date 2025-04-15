<?php

namespace App\Filament\Clusters\IntermedianoUruguay\Resources;

use App\Filament\Clusters\IntermedianoUruguay;
use App\Filament\Clusters\IntermedianoUruguay\Resources\EmployeeExpensesResource\Pages;
use App\Filament\Clusters\IntermedianoUruguay\Resources\EmployeeExpensesResource\RelationManagers;
use App\Models\Contract;
use App\Models\EmployeeExpenses;
use App\Models\Quotation;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\Repeater;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Section;
use Maatwebsite\Excel\Facades\Excel;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use Illuminate\Support\Str;

class EmployeeExpensesResource extends Resource
{
    protected static ?string $model = EmployeeExpenses::class;

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = IntermedianoUruguay::class;

    public static function form(Form $form): Form
    {
        $employeeCompanyId = Contract::where('employee_id', auth()->user()->id)->value('company_id');
        $employeeQuotationId = Contract::where('employee_id', auth()->user()->id)->value('quotation_id');
        $currencyName = Quotation::where('id', $employeeQuotationId)->value('currency_name');

        return $form
            ->schema([
                Forms\Components\TextInput::make('cost_center')
                    ->columnSpan(2),

                Forms\Components\Select::make('type')
                    ->options([
                        'local' => 'Local',
                        'abroad' => 'Abroad',
                    ])
                    ->live()
                    ->columnSpan(2)
                    ->required(),

                Forms\Components\TextInput::make('currency_name')
                    ->default($currencyName)
                    ->columnSpan(1)
                    ->hidden(fn(Get $get) => !$get('type') || $get('type') === 'local'),


                Repeater::make('expenses')
                    ->schema([
                        Forms\Components\TextInput::make('item')
                            ->label('Item')
                            ->disabled()
                            ->dehydrated()
                            ->default(function ($state, Forms\Components\Component $component) {
                                if ($state !== null) {
                                    return $state;
                                }

                                $repeater = $component->getContainer()->getParentComponent();
                                $existingItems = $repeater->getState() ?? [];

                                $savedItems = array_filter($existingItems, fn($item) => isset($item['item']));

                                return count($savedItems) + 1;
                            }),
                        Forms\Components\TextInput::make('description')
                            ->required(),

                        Forms\Components\DatePicker::make('date')
                            ->displayFormat('d-m-Y')
                            ->placeholder('dd-mm-yy')
                            ->native(false)
                            ->required(),

                        Forms\Components\TextInput::make('amount')
                            ->numeric()
                            ->hidden(fn(Get $get) => $get('../../type') !== 'local'),

                        Forms\Components\TextInput::make('federal_amount')
                            ->numeric()
                            ->hidden(fn(Get $get) => $get('../../type') !== 'local'),


                        Forms\Components\TextInput::make('state_amount')
                            ->numeric()
                            ->hidden(fn(Get $get) => $get('../../type') !== 'local'),

                        Forms\Components\TextInput::make('local_currency_include_taxes')

                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::updateExpenseTotals($get, $set);
                            })
                            ->live(onBlur: true)
                            ->dehydrated()
                            ->hidden(fn(Get $get) => $get('../../type') !== 'local'),

                        Forms\Components\TextInput::make('usd')
                            ->label('USD')
                            ->numeric()
                            ->hidden(fn(Get $get) => $get('../../type') !== 'abroad'),

                        Forms\Components\TextInput::make('exchange_rate')
                            ->numeric()
                            ->hidden(fn(Get $get) => $get('../../type') !== 'abroad')
                            ->reactive()
                            ->afterStateUpdated(fn(Get $get, Set $set, $state) => $set('local_currency', ($get('usd') ?? 0) * $state)),

                        Forms\Components\TextInput::make('local_currency')
                            ->label('BRL')
                            ->disabled()
                            ->numeric()
                            ->hidden(fn(Get $get) => $get('../../type') !== 'abroad'),
                        Forms\Components\FileUpload::make('invoice')
                            ->label('Invoice File')
                            ->disk('public')
                            ->disablePreview()
                            ->directory('invoices')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                            ->imagePreviewHeight(150)
                            ->preserveFilenames()
                            ->required(),
                        Forms\Components\Hidden::make('status')

                            ->default('pending')
                    ])
                    ->columns(8)
                    ->itemLabel(function (array $state): ?HtmlString {
                        $description = $state['description'] ?? 'N/A';
                        $status = $state['status'] ?? 'Unknown';
                        $comments = $state['comments'] ?? '';

                        $badgeColor = match (strtolower($status)) {
                            'approved' => 'green',
                            'pending' => 'orange',
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
                    ->live()
                    ->minItems(1)
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::updateExpenseTotals($get, $set);
                    })
                    ->columnSpanFull()
                    ->cloneable(),

                Forms\Components\Hidden::make('employee_id')
                    ->default(auth()->user()->id),

                Forms\Components\Hidden::make('company_id')
                    ->default($employeeCompanyId),

                Forms\Components\Hidden::make('created_by')
                    ->default('employee'),

                Forms\Components\Hidden::make('status')
                    ->default('pending'),
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
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Expense Period')
                    ->formatStateUsing(function ($record) {
                        $date = $record->created_at->format('m-Y');
                        $currency = $record->type === 'local'
                            ? ($record->currency_name ?? 'BRL')
                            : 'USD';

                        return "Expenses {$date}_{$currency}";
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Company')
                    ->sortable()
                    ->searchable(),

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
                        $currency =  getCurrencyByCompany($record->employee->company);
                        $employee = $record->employee->name ?? 'N/A';
                        $company = $record->company->name ?? 'N/A';
                        $companyIntermediano = $record->employee->company ?? 'N/A';
                        $costCenter = $record->cost_center ?? 'N/A';
                        $expenses = $record->expenses;
                        $formattedDate = Carbon::parse($record->created_at)->format('m_Y');

                        $isLocal = $record->type === 'local' ? $record->currency_name : 'USD';
                        $formattedExpenses = array_map(function ($expense) use ($employee, $company, $record, $currency) {
                            return [
                                'currency' => $currency,
                                'Employee' => $employee,
                                'Company' => $company,
                                'Description' => $expense['description'] ?? 'N/A',
                                'Date' => $expense['date'] ?? 'N/A',
                                'Amount' => $expense['amount'] ?? 0,
                                'Federal Amount' => $expense['federal_amount'] ?? 0,
                                'State Amount' => $expense['state_amount'] ?? 0,
                                'BRL (Include Taxes)' => $expense['local_currency_include_taxes'] ?? 0,
                                'USD' => $expense['usd'] ?? 0,
                                'Exchange Rate' => $expense['exchange_rate'] ?? 'N/A',
                                'BRL' => $expense['local_currency'] ?? 0,
                                'Status' => $record->status === 'approved' ? 'Approved' : $expense['status'],
                                'Comments' => $expense['comments'] ?? '',
                                // 'Local Total' => $expense['local_total'] ?? 0,
                                // 'Abroad Total' => $expense['abroad_total'] ?? 0,
                                // 'Grand Total' => $expense['grand_total'] ?? 0,
                            ];
                        }, $expenses);
                        return Excel::download(new EmployeeExpensesExport($formattedExpenses, $companyIntermediano, $costCenter),  'Expenses_' . $formattedDate . '_' . $isLocal . '_' . $employee . '.xlsx');

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
                $localTotal += (float)($expense['local_currency_include_taxes'] ?? 0);
            } else {
                $abroadTotal += (float)($expense['usd'] ?? 0);
            }
        }

        $set('local_total', number_format($localTotal, 2, '.', ''));
        $set('abroad_total', number_format($abroadTotal, 2, '.', ''));
        $set('grand_total', number_format($type === 'local' ? $localTotal : $abroadTotal, 2, '.', ''));
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
            'index' => Pages\ListEmployeeExpenses::route('/'),
            'create' => Pages\CreateEmployeeExpenses::route('/create'),
            'edit' => Pages\EditEmployeeExpenses::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $getEmployeeExpenses = EmployeeExpenses::whereHas('employee', function($query) {
            $query->where('company', 'IntermedianoUruguay');
        });
        return $getEmployeeExpenses;
    }
    public static function canEdit($record): bool
    {
        return $record->status !== 'approved';
    }
}
