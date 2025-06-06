<?php

namespace App\Filament\Clusters\IntermedianoEcuadorSAS\Resources;

use App\Filament\Clusters\IntermedianoEcuadorSAS;
use App\Filament\Clusters\IntermedianoEcuadorSAS\Resources\EmployeeContractResource\Pages;
use App\Filament\Clusters\IntermedianoEcuadorSAS\Resources\EmployeeContractResource\RelationManagers;
use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Components\RichEditor;
use Carbon\Carbon;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\Filter;
use Stichoza\GoogleTranslate\GoogleTranslate;

class EmployeeContractResource extends Resource
{
    protected static ?string $model = Contract::class;
    protected static ?string $label = 'Employee Contract';
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = IntermedianoEcuadorSAS::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('contract_type')
                    ->default('employee'),
                Forms\Components\Select::make('company_id')
                    ->label('Customer')
                    ->relationship('company', 'name', fn(Builder $query) => $query->where('is_customer', true))
                    ->required(),
                Forms\Components\Select::make('employee_id')
                    ->relationship('employee', 'name', fn(Builder $query) => $query->where('company', 'IntermedianoEcuadorSAS'))
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
                RichEditor::make('job_description')->columnSpanFull(),
                RichEditor::make('translated_job_description')->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ToggleColumn::make('is_sent_to_employee')
                    ->label('Sent to Employee')
                    ->sortable()
                    ->toggleable(),
                BadgeColumn::make('signature')
                    ->sortable()
                    ->colors([
                        'success' => fn($state) => $state !== null,
                        'warning' => fn($state) => $state == 'Pending Signature',
                    ])
                    ->label('Signature Status')
                    ->formatStateUsing(fn($state) => $state !== 'Pending Signature' ? 'Signed' : 'Pending Signature'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('end_date')
                    ->label('Contract Period')
                    ->options([
                        'defined' => 'Defined Period Contract',
                        'undefined' => 'Undefined Period Contract',
                        'both' => 'Both',
                    ])
                    ->query(function (Builder $query, $state) {
                        switch ($state['value']) {
                            case 'defined':
                                return $query->whereNot('end_date', null);
                            case 'undefined':
                                return $query->where('end_date', null);
                            case 'both':
                            default:
                                return $query;
                        }
                    })
                    ->default('both'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('pdf')
                    ->label('Download Contract')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record) {
                        $pdfPage = 'pdf.contract.ecuador.consultant';
                        $year = date('Y', strtotime($record->created_at));
                        $formattedId = sprintf('%04d', $record->id);
                        $tr = new GoogleTranslate();
                        $tr->setSource();
                        $tr->setTarget('en');
                        $record->translatedPosition = $tr->translate($record->job_title ?? "");
                        $contractTitle = $year . '.' . $formattedId;
                        $startDateFormat = Carbon::parse($record->start_date)->format('d.m.y');
                        $fileName = $startDateFormat . '_Contrato Individual de ' . $record->employee->name . '_of employee';

                        $footerDetails = [
                            'companyName' => 'INTERMEDIANO ECUADOR SAS',
                            'address' => 'Av Francisco Orellana E12-148 y Av 12 de Octubre, Oficina 206, Mariscal Sucre, Quito, Pichincha, Ecuador',
                            'domain' => 'www.intermediano.com',
                            'mobile' => '+1 514-907-5393'
                        ];

                        $pdf = Pdf::loadView($pdfPage, [
                            'record' => $record,
                            'poNumber' => $contractTitle,
                            'is_pdf' => true,
                            'footerDetails' => $footerDetails,
                        ]);

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
            'index' => Pages\ListEmployeeContracts::route('/'),
            'create' => Pages\CreateEmployeeContract::route('/create'),
            'edit' => Pages\EditEmployeeContract::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $contractCluster = Contract::where('cluster_name', self::getClusterName())->where('contract_type', 'employee');
        return $contractCluster;
    }
    protected static function getClusterName(): string
    {
        return class_basename(self::$cluster);
    }
}
