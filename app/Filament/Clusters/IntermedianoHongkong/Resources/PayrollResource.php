<?php

namespace App\Filament\Clusters\IntermedianoHongkong\Resources;

use App\Exports\QuotationExport;
use App\Filament\Clusters\IntermedianoHongkong;
use App\Filament\Clusters\IntermedianoHongkong\Resources\PayrollResource\Pages;
use App\Filament\Clusters\IntermedianoHongkong\Resources\PayrollResource\RelationManagers;
use App\Models\Quotation;
use App\Models\Consultant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use Filament\Forms\Components\TextInput;
use Filament\Support\RawJs;
use Filament\Forms\Components\Fieldset;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
class PayrollResource extends Resource
{
    protected static ?string $model = Quotation::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 6;
    protected static ?string $cluster = IntermedianoHongkong::class;
    protected static ?string $label = 'Payroll';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('title')
                    ->label('Title')
                    ->displayFormat('Y-m-d')
                    ->placeholder('yy-mm-dd')
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('company_id')
                    ->label('Customer')
                    ->relationship('company', 'name', fn(Builder $query) => $query->where('is_customer', true))
                    ->required(),
                Forms\Components\Hidden::make('country_id')
                    ->default(function () {
                        return \App\Models\Country::where('name', 'Hong Kong')->value('id');
                    })
                    ->reactive(),
                Forms\Components\Select::make('consultant_id')
                    ->label('Consultant')
                    ->relationship('consultant', 'name')
                    ->required(),
                Forms\Components\TextInput::make('currency_name')
                    ->label('Currency Name')
                    ->placeholder('Enter currency code (e.g., USD, EUR, BRL)')
                    ->required(),

                Forms\Components\TextInput::make('exchange_rate')
                    ->numeric()
                    ->required(),

                TextInput::make('exchange_acronym')
                    ->label('billing currency')
                    ->placeholder('Enter exchange acronym (e.g., USD)')
                    ->required(),

                Forms\Components\TextInput::make('gross_salary')
                    ->mask(RawJs::make(<<<'JS'
                        $money($input, '.', ',', 2)
                    JS))
                    ->afterStateUpdated(function ($component, $state) {
                        $cleanedState = preg_replace('/[^0-9\.]+/', '', $state);

                        $component->state($cleanedState);
                    })
                    ->required(),
                Forms\Components\Select::make('is_fix_fee')
                    ->label('Type of fee')
                    ->required()
                    ->options([
                        '1' => 'Fix Rate',
                        '0' => 'Percentage Rate',
                    ]),
                Forms\Components\TextInput::make('fee')
                    ->required(),

                Forms\Components\TextInput::make('bank_fee')
                    ->label('Bank Fee ($)')
                    ->mask(RawJs::make(<<<'JS'
                $money($input, '.', ',', 2)
            JS))
                    ->afterStateUpdated(function ($component, $state) {
                        $cleanedState = preg_replace('/[^0-9\.]+/', '', $state);

                        $component->state($cleanedState);
                    })
                    ->required(),

                Forms\Components\TextInput::make('bonus')
                    ->mask(RawJs::make(<<<'JS'
                    $money($input, '.', ',', 2);
                JS))
                    ->afterStateUpdated(function ($component, $state) {
                        $cleanedState = preg_replace('/[^0-9\.]+/', '', $state);

                        $component->state($cleanedState);
                    })
                    ->required(),

                Forms\Components\TextInput::make('home_allowance')
                    ->mask(RawJs::make(<<<'JS'
                    $money($input, '.', ',', 2)
                    JS))
                    ->afterStateUpdated(function ($component, $state) {
                        $cleanedState = preg_replace('/[^0-9\.]+/', '', $state);

                        $component->state($cleanedState);
                    })
                    ->required(),
                Forms\Components\TextInput::make('medical_allowance')
                    ->mask(RawJs::make(<<<'JS'
                    $money($input, '.', ',', 2)
                    JS))
                    ->afterStateUpdated(function ($component, $state) {
                        $cleanedState = preg_replace('/[^0-9\.]+/', '', $state);

                        $component->state($cleanedState);
                    })
                    ->default(0)
                    ->required(),
                Forms\Components\TextInput::make('transport_allowance')
                    ->mask(RawJs::make(<<<'JS'
                    $money($input, '.', ',', 2)
                    JS))
                    ->afterStateUpdated(function ($component, $state) {
                        $cleanedState = preg_replace('/[^0-9\.]+/', '', $state);

                        $component->state($cleanedState);
                    })
                    // ->visible(fn(Get $get): bool => !$get('is_integral'))
                    ->default(0)
                    ->required(),
                Forms\Components\TextInput::make('internet_allowance')
                    ->mask(RawJs::make(<<<'JS'
                    $money($input, '.', ',', 2)
                    JS))
                    ->afterStateUpdated(function ($component, $state) {
                        $cleanedState = preg_replace('/[^0-9\.]+/', '', $state);

                        $component->state($cleanedState);
                    })
                    ->default(0)
                    ->required(),

                Forms\Components\TextInput::make('uvt_amount')
                    ->default(0)
                    ->hidden(true)
                    ->label('UVT Amount'),
                Forms\Components\TextInput::make('capped_amount')
                    ->default(0)
                    ->hidden(true)
                    ->label('Capped (LIMIT) Social Security'),
                Forms\Components\Select::make('dependent')
                    ->options([
                        '1' => 'Yes',
                        '0' => 'No',
                    ])
                    ->required(),
                \App\Helpers\BrazilPayrollCostsFormHelper::getPayrollCostsFieldset(),
                Repeater::make('payment_provisions')
                    ->label('Payment Provisions')
                    ->relationship('paymentProvisions')
                    ->schema([
                        Select::make('provision_type_id')
                            ->label('Provision Type')
                            ->required()
                            ->options(function (callable $get, callable $set) {

                                $allowedNames = [
                                    'Leave',
                                ];

                                // Get only the allowed provision types
                                $allOptions = \App\Models\ProvisionType::whereIn('name', $allowedNames)
                                    ->pluck('name', 'id');

                                $current = $get('provision_type_id');

                                $allSelected = collect($get('../../payment_provisions'))
                                    ->pluck('provision_type_id')
                                    ->filter()
                                    ->reject(fn($id) => $id === $current)
                                    ->toArray();

                                return $allOptions->reject(function ($name, $id) use ($allSelected) {
                                    return in_array($id, $allSelected);
                                });
                            })
                            ->searchable(),
                        Forms\Components\TextInput::make('amount')
                            ->label('Amount (Local Currency)')
                            ->numeric()
                            ->required(),
                        Forms\Components\Hidden::make('country_id')
                            ->default(function () {
                                return \App\Models\Country::where('name', 'Brazil')->value('id');
                            }),
                        Forms\Components\Hidden::make('cluster_name')
                            ->default(self::getClusterName()),
                    ])
                    ->columnSpanFull()
                    ->columns(2)
                    ->grid(2)
                    ->defaultItems(0)
                    ->createItemButtonLabel('Add Provision Payment'),
                Forms\Components\Hidden::make('cluster_name')
                    ->default(self::getClusterName()),
                Forms\Components\Hidden::make('is_payroll')
                    ->default(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Id')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Quotation title')
                    ->dateTime('y-m-d')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('consultant.name')
                    ->label('Consultant Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('country.name')
                    ->label('Country')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Company')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),

                Filter::make('cluster_match')
                    ->label('Company Name')
                    ->query(fn(Builder $query): Builder => $query->where('cluster_name', self::getClusterName()))
                    ->default(),
                Filter::make('is_payroll')
                    ->query(fn(Builder $query): Builder => $query->where('is_payroll', true))
                    ->default(),

                SelectFilter::make('consultant_id')
                    ->label('Consultant')
                    ->options(Consultant::all()->pluck('name', 'id')),
                Filter::make('Month')
                    ->form([
                        DatePicker::make('month')
                            ->displayFormat('Y-m')
                            ->placeholder('Select Month')
                            ->extraInputAttributes(['type' => 'month'])

                            ->native(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['month']) {
                            $query->whereMonth('title', Carbon::parse($data['month'])->month);
                        }
                    }),
            ])

            ->actions([
                Tables\Actions\Action::make('view_quotation')
                    ->label('View Payroll')
                    ->modal()
                    ->modalSubmitAction(false)
                    ->modalContent(function ($record) {
                        $viewModal = 'filament.quotations.hongkong_modal';
                        return view($viewModal, [
                            'record' => $record,
                        ]);
                    }),
                ExportAction::make('export')
                    ->label('Export Details')
                    ->action(function ($record) {

                        $currentDate = Carbon::parse($record->title);
                        $previousMonthDate = $currentDate->subMonth();

                        $previousRecords = Quotation::where('consultant_id', $record->consultant_id)
                            ->whereNull('deleted_at')
                            ->where('title', '<', $record->title)
                            ->where('cluster_name', 'IntermedianoHongkong')
                            ->get();

                        $record->uniqueCurrencies = $previousRecords->pluck('currency_name')->unique();
                        $export = new QuotationExport($record, $previousRecords);
                        $companyName = $record->company->name;

                        $transformTitle = str_replace('/', '.', $record->title);
                        return Excel::download($export, $transformTitle . '_Payroll for ' . self::getClusterName() . ' ' . $record->consultant->name . '.xlsx');
                    }),
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record) {
                        $pdfPage = 'pdf.hong_kong_quotation';
                        $companyName = $record->company->name;
                        $transformTitle = str_replace(['/', '\\'], '.', $record->title);
                        $pdf = Pdf::loadView($pdfPage, ['record' => $record]);
                        return response()->streamDownload(
                            fn() => print ($pdf->output()),
                            Str::slug($transformTitle, '.') . '_Payroll for ' . $companyName . ' ' . self::getClusterName() . '.pdf'
                        );
                    }),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPayrolls::route('/'),
            'create' => Pages\CreatePayroll::route('/create'),
            'edit' => Pages\EditPayroll::route('/{record}/edit'),
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
