<?php

namespace App\Filament\Clusters\IntermedianoUruguay\Resources;

use App\Filament\Clusters\IntermedianoUruguay;
use App\Filament\Clusters\IntermedianoUruguay\Resources\CustomerContractResource\Pages;
use App\Filament\Clusters\IntermedianoUruguay\Resources\CustomerContractResource\RelationManagers;
use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\BadgeColumn;
use Carbon\Carbon;
use Stichoza\GoogleTranslate\GoogleTranslate;
class CustomerContractResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static ?string $label = 'Client Contract';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = IntermedianoUruguay::class;
    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('contract_type')
                    ->default('customer'),
                Forms\Components\Select::make('company_id')
                    ->label('Customer')
                    ->relationship('company', 'name', fn(Builder $query) => $query->where('is_customer', true))
                    ->required(),
                Forms\Components\Select::make('employee_id')
                    ->relationship('employee', 'name', fn(Builder $query) => $query->where('company', 'IntermedianoUruguay'))
                    ->required(),
                Forms\Components\Select::make('quotation_id')
                    ->relationship(
                        'quotation',
                        'title',
                        fn(Builder $query) => $query->where('cluster_name', 'IntermedianoUruguay')->where('is_payroll', '0')
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
                Forms\Components\Hidden::make('cluster_name')
                    ->default(self::getClusterName())
                    ->label(self::getClusterName()),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.name')
                    ->numeric()
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
                        $pdfPage = 'pdf.contract.uruguay.client';
                        $year = date('Y', strtotime($record->created_at));
                        $formattedId = sprintf('%04d', $record->id);

                        $tr = new GoogleTranslate();
                        $tr->setSource();
                        $tr->setTarget('es');
                        $record->translatedPosition = $tr->translate($record->companyContact->position ?? "");
                        $contractTitle = $year . '.' . $formattedId;
                        $startDateFormat = Carbon::parse($record->start_date)->format('d.m.y');
                        $fileName = $startDateFormat . '_Contract with_' . $record->company->name . '_of employee_CL';
                        $footerDetails = [
                            'companyName' => 'Intermediano S.A.S.',
                            'address' => '',
                            'domain' => 'sac@intermediano.com',
                            'mobile' => ''
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
            'index' => Pages\ListCustomerContracts::route('/'),
            'create' => Pages\CreateCustomerContract::route('/create'),
            'edit' => Pages\EditCustomerContract::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        $contractCluster = Contract::where('cluster_name', self::getClusterName())->where('contract_type', 'customer');
        return $contractCluster;
    }
    protected static function getClusterName(): string
    {
        return 'ClientContractUruguay';
    }
}
