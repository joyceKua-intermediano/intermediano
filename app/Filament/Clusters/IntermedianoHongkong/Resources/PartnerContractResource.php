<?php

namespace App\Filament\Clusters\IntermedianoHongkong\Resources;

use App\Filament\Clusters\IntermedianoHongkong;
use App\Filament\Clusters\IntermedianoHongkong\Resources\PartnerContractResource\Pages;
use App\Models\Company;
use App\Models\Contract;
use App\Models\IntermedianoCompany;
use App\Models\Partner;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Filament\Tables\Columns\BadgeColumn;
use Stichoza\GoogleTranslate\GoogleTranslate;
class PartnerContractResource extends Resource
{
    protected static ?string $model = Contract::class;
    protected static ?string $label = 'Partner Contract';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 8;
    protected static ?string $cluster = IntermedianoHongkong::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('contract_type')
                    ->default('partner'),
                Forms\Components\Select::make('combined_select')
                    ->label('Partner or Company')
                    ->options(function () {
                        $partners = Partner::all()->pluck('partner_name', 'id')->mapWithKeys(function ($name, $id) {
                            return ["partner_$id" => "Partner: $name"];
                        });

                        $companies = IntermedianoCompany::all()->pluck('name', 'id')->mapWithKeys(function ($name, $id) {
                            return ["company_$id" => "Internal Company: $name"];
                        });

                        return $partners->merge($companies)->toArray();
                    })
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if (str_starts_with($state, 'partner_')) {

                            $set('partner_id', str_replace('partner_', '', $state));
                            $set('intermediano_company_id', null);
                        } elseif (str_starts_with($state, 'company_')) {
                            $set('intermediano_company_id', str_replace('company_', '', $state));
                            $set('partner_id', null);
                        }
                    }),
                Forms\Components\Select::make('employee_id')
                    ->relationship('employee', 'name', fn(Builder $query) => $query->where('company', 'IntermedianoHongkong'))
                    ->required(),
                Forms\Components\Select::make('quotation_id')
                    ->relationship(
                        'quotation',
                        'title',
                        fn(Builder $query) => $query->where('cluster_name', 'IntermedianoHongkong')->where('is_payroll', '0')
                    )
                    ->required(),
                Forms\Components\TextInput::make('country_work')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('job_title')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DatePicker::make('start_date')
                    ->displayFormat('d-m-y')
                    ->placeholder('dd-mm-yy')
                    ->native(false),
                Forms\Components\DatePicker::make('end_date')
                    ->displayFormat('d-m-y')
                    ->placeholder('dd-mm-yy')
                    ->native(false),
                Forms\Components\TextInput::make('gross_salary')
                    ->mask(RawJs::make(<<<'JS'
                $money($input, '.', ',', 2)
            JS))
                    ->afterStateUpdated(function ($component, $state) {
                        $cleanedState = preg_replace('/[^0-9\.]+/', '', $state);

                        $component->state($cleanedState);
                    })
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\Fieldset::make('Label')
                    ->relationship('supplementaryContractDetails')

                    ->schema([
                        Forms\Components\TextInput::make('standard_working_hours')
                            ->placeholder('ex: 8hours')

                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('shift_schedule')
                            ->placeholder('ex: 8:00am - 5:00pm')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('notice_period')
                            ->placeholder('ex: 30days, 60days, 90days')
                            ->maxLength(255)
                            ->default(null),

                        Forms\Components\TextInput::make('payment_terms')
                            ->placeholder('ex: from invoice date - 15days, 30days')
                            ->maxLength(255)
                            ->default(null),

                        Forms\Components\TextInput::make('billing_currency')
                            ->placeholder('ex: USD-HKD')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('payment_currency')
                            ->placeholder('ex: USD-HKD')
                            ->maxLength(255)
                            ->default(null),
                    ]),

                Forms\Components\Hidden::make('partner_id')
                    ->dehydrateStateUsing(fn($state) => $state),

                Forms\Components\Hidden::make('intermediano_company_id')
                    ->dehydrateStateUsing(fn($state) => $state),
                Forms\Components\Hidden::make('cluster_name')
                    ->default(self::getClusterName())
                    ->label(self::getClusterName()),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('entity_name')
                    ->label('Partner/Company Name')
                    ->getStateUsing(function ($record) {
                        return $record->partner?->partner_name ?? $record->IntermedianoCompany?->name ?? 'N/A';
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('country_work')
                    ->searchable(),
                Tables\Columns\TextColumn::make('job_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gross_salary')
                    ->searchable(),
                BadgeColumn::make('signature')
                    ->sortable()
                    ->colors([
                        'success' => fn($state) => $state !== null,
                        'warning' => fn($state) => $state == 'Pending Signature',
                    ])
                    ->label('Signature Status')
                    ->formatStateUsing(fn($state) => $state !== 'Pending Signature' ? 'Signed' : 'Pending Signature'),
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
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('pdf')
                    ->label('Download Contract')
                    ->icon('heroicon-o-arrow-down-tray')

                    ->action(function ($record) {
                        $pdfPage = 'pdf.contract.hongkong.partner';
                        $year = date('Y', strtotime($record->created_at));
                        $formattedId = sprintf('%04d', $record->id);

                        $tr = new GoogleTranslate();
                        $contractTitle = $year . '.' . $formattedId;
                        $startDateFormat = Carbon::parse($record->start_date)->format('d.m.y');
                        $companyName = $record->partner->partner_name ?? $record->intermedianoCompany->name;
                        $fileName = $startDateFormat . '_Contract with_' . $companyName . '_of employee';
                        $footerDetails = [
                            'companyName' => 'Intermediano Hong Kong Limited',
                            'address' => '4388 Rue Saint-Denis Suite200 #763, Montreal, QC H2J 2L1, Canada',
                            'domain' => 'www.intermediano.com',
                            'mobile' => '+1 514 907 5393'
                        ];
                        $pdf = Pdf::loadView($pdfPage, ['record' => $record, 'poNumber' => $contractTitle, 'is_pdf' => true, 'footerDetails' => $footerDetails]);
                        return response()->streamDownload(
                            fn() => print ($pdf->output()),
                            $fileName . '.pdf'
                        );
                    }),
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
            'index' => Pages\ListPartnerContracts::route('/'),
            'create' => Pages\CreatePartnerContract::route('/create'),
            'edit' => Pages\EditPartnerContract::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $contractCluster = Contract::where('cluster_name', self::getClusterName())->where('contract_type', 'partner');
        return $contractCluster;
    }
    protected static function getClusterName(): string
    {
        return 'PartnerContractHongkong';
    }
}
