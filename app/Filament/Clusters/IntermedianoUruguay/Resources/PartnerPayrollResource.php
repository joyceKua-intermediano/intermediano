<?php

namespace App\Filament\Clusters\IntermedianoUruguay\Resources;

use App\Exports\PartnerPayrollExport;
use App\Exports\QuotationExport;
use App\Filament\Clusters\IntermedianoUruguay;
use App\Filament\Clusters\IntermedianoUruguay\Resources\PartnerPayrollResource\Pages;
use App\Filament\Clusters\IntermedianoUruguay\Resources\PartnerPayrollResource\RelationManagers;
use App\Models\Quotation;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Set;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\TextInput;
use Filament\Support\RawJs;
use Filament\Forms\Components\Hidden;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms\Get;


class PartnerPayrollResource extends Resource
{
    protected static ?string $model = Quotation::class;
    protected static ?string $label = 'Partner Payroll';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = IntermedianoUruguay::class;
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('title')
                    ->label('Date')
                    ->displayFormat('Y-m-d')
                    ->placeholder('yy-mm-dd')
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('company_id')
                    ->label('Customer')
                    ->relationship('company', 'name')
                    ->required(),
                Forms\Components\Select::make('country_id')
                    ->label('Country')
                    ->relationship('country', 'name', function ($query) {
                        $query->whereIn('name', ['Panama', 'Nicaragua', 'El Salvador', 'Honduras', 'Guatemala', 'Jamaica', 'Dominican Republic']);
                    })
                    ->required(),
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
                Forms\Components\TextInput::make('legal_grafication')
                    ->label('Legal Gratification')
                    ->mask(RawJs::make(<<<'JS'
                    $money($input, '.', ',', 2)
                    JS))
                    ->afterStateUpdated(function ($component, $state) {
                        $cleanedState = preg_replace('/[^0-9\.]+/', '', $state);

                        $component->state($cleanedState);
                    })
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
                    ->required()
                    ->reactive(),
                Fieldset::make('PayrollCosts')
                    ->relationship('payrollCosts')
                    ->label('Payroll Costs')
                    ->schema([
                        TextInput::make('notice')->label('Notice'),
                        TextInput::make('unemployment')->label('Unemployment'),
                    ]),
                Forms\Components\Hidden::make('cluster_name')
                    ->default('PartnerUruguay')
                    ->label('PartnerUruguay'),
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
                    ->label('Consultant')
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
                    ->query(fn(Builder $query): Builder => $query->where('cluster_name', 'PartnerUruguay'))
                    ->default(),
                Filter::make('is_payroll')
                    ->query(fn(Builder $query): Builder => $query->where('is_payroll', true))
                    ->default(),
                Tables\Filters\SelectFilter::make('country')
                    ->relationship('country', 'name')
                    ->preload()
                    ->searchable()
                    ->multiple(),
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
                    ->label('View Quotation')
                    ->modal()
                    ->modalSubmitAction(false)
                    ->modalContent(function ($record) {
                        $viewModal = [
                            'Panama' => 'filament.quotations.panama_modal',
                            'Nicaragua' => 'filament.quotations.nicaragua_modal',
                            'Dominican Republic' => 'filament.quotations.dominican_republic_modal',
                        ];
                        $viewModal = $viewModal[$record->country->name] ?? null;

                        return view($viewModal, [
                            'record' => $record,
                        ]);
                    }),
                ExportAction::make('export')
                    ->label('Export Details')
                    ->action(function ($record) {
                        $currentDate = Carbon::parse($record->title);
                        $previousMonthDate = $currentDate->subMonth();

                        $previousMonthRecord = Quotation::where('consultant_id', $record->consultant_id)
                            ->where('country_id', $record->country->id)
                            ->whereNull('deleted_at')
                            ->whereMonth('title', $previousMonthDate->month)
                            ->whereYear('title', $previousMonthDate->year)
                            ->first();

                        $export = new QuotationExport($record, $previousMonthRecord);
                        $companyName = $record->company->name;

                        $transformTitle = str_replace('/', '.', $record->title);
                        return Excel::download($export, $transformTitle . '_Payroll for ' . $companyName . ' ' . $record->consultant->name . '.xlsx');
                    }),
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record) {
                        $pdfPages = [
                            'Panama' => 'pdf.panama_quotation',
                            'Nicaragua' => 'pdf.nicaragua_quotation',
                            'Dominican Republic' => 'pdf.dominican_republic_quotation',
                        ];
                        $pdfPage = $pdfPages[$record->country->name] ?? null;

                        $companyName = $record->company->name;
                        $transformTitle = str_replace(['/', '\\'], '.', $record->title);
                        $pdf = Pdf::loadView($pdfPage, ['record' => $record]);
                        return response()->streamDownload(
                            fn() => print ($pdf->output()),
                            Str::slug($transformTitle, '.') . '_Payroll for ' . $companyName . '.pdf'
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
            'index' => Pages\ListPartnerPayrolls::route('/'),
            'create' => Pages\CreatePartnerPayroll::route('/create'),
            'edit' => Pages\EditPartnerPayroll::route('/{record}/edit'),
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
