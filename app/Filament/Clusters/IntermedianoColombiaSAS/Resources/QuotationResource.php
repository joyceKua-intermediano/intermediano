<?php

namespace App\Filament\Clusters\IntermedianoColombiaSAS\Resources;

use App\Exports\QuotationExport;
use App\Filament\Clusters\IntermedianoColombiaSAS;
use App\Filament\Clusters\IntermedianoColombiaSAS\Resources\QuotationResource\Pages;
use App\Filament\Clusters\IntermedianoColombiaSAS\Resources\QuotationResource\RelationManagers;
use App\Models\Quotation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Support\RawJs;
use Filament\Forms\Components\Hidden;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Set;
use Filament\Tables\Filters\TernaryFilter;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = IntermedianoColombiaSAS::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('is_integral')
                    ->live()
                    ->required()
                    ->label('Type of Quotation')
                    ->options([
                        '0' => 'Ordinary',
                        '1' => 'Integral',
                    ]),
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
                Forms\Components\Hidden::make('country_id')
                    ->default(function () {
                        return \App\Models\Country::where('name', 'Colombia')->value('id');
                    }),

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
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state, Get $get) {

                        if ($state === '0') {
                            $set('capped_amount', null);
                        } else {
                            $annualSetup = \App\Models\CountryAnnualSetup::where('country_id', $get('country_id'))->latest('year')->first();
                            $set('capped_amount', $annualSetup->capped_amount ?? 0);
                        }
                        $annualSetup = \App\Models\CountryAnnualSetup::where('country_id', $state)->latest('year')->first();
                    }),

                Forms\Components\Hidden::make('cluster_name')
                    ->default(self::getClusterName())
                    ->label(self::getClusterName()),
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
                    ->formatStateUsing(fn($record) => $record->title . ' (' . ($record->is_integral ? 'Integral' : 'Ordinary') . ')')
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
                    ->label('Is Quotation')
                    ->query(fn(Builder $query): Builder => $query->where('is_payroll', false))
                    ->default(),
                TernaryFilter::make('is_integral')->label('Is Integral Payroll?'),
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
                        $isIntegral = $record->is_integral;
                        $viewModal = $isIntegral ? 'filament.quotations.integral_modal' : 'filament.quotations.ordinary_modal';
                        return view($viewModal, [
                            'record' => $record,
                        ]);
                    }),
                ExportAction::make('export')
                    ->label('Export Details')
                    ->action(function ($record) {
                        $isQuotation = true;
                        $export = new QuotationExport($record, [], $isQuotation);
                        $companyName = $record->company->name;

                        $transformTitle = str_replace('/', '.', $record->title);
                        return Excel::download($export, $transformTitle . '_Quotation for ' . $companyName . '.xlsx');
                    }),
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record) {
                        $isIntegral = $record->is_integral;
                        $pdfPage = $isIntegral ? 'pdf.integral_quotation' : 'pdf.ordinary_quotation';
                        $companyName = $record->company->name;
                        $transformTitle = str_replace(['/', '\\'], '.', $record->title);
                        $pdf = Pdf::loadView($pdfPage, ['record' => $record]);
                        return response()->streamDownload(
                            fn() => print ($pdf->output()),
                            Str::slug($transformTitle, '.') . '_Quotation for ' . $companyName . '.pdf'
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
            'index' => Pages\ListQuotations::route('/'),
            'create' => Pages\CreateQuotation::route('/create'),
            'edit' => Pages\EditQuotation::route('/{record}/edit'),
        ];
    }

    protected static function getClusterName(): string
    {
        return class_basename(self::$cluster);
    }
}
