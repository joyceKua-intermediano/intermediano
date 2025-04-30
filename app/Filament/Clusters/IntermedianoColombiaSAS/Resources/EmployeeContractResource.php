<?php

namespace App\Filament\Clusters\IntermedianoColombiaSAS\Resources;

use App\Filament\Clusters\IntermedianoColombiaSAS;
use App\Filament\Clusters\IntermedianoColombiaSAS\Resources\EmployeeContractResource\Pages;
use App\Filament\Clusters\IntermedianoColombiaSAS\Resources\EmployeeContractResource\RelationManagers;
use App\Models\Contract;
use App\Models\Quotation;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Str;
use Filament\Forms\Components\RichEditor;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Support\RawJs;

class EmployeeContractResource extends Resource
{
    protected static ?string $model = Contract::class;
    protected static ?string $label = 'Employee Contract';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = IntermedianoColombiaSAS::class;

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
                    ->relationship('employee', 'name', fn(Builder $query) => $query->where('company', 'IntermedianoColombiaSAS'))
                    ->required(),
                Forms\Components\Select::make('is_integral')
                    ->options([
                        '1' => 'Integral',
                        '0' => 'Ordinary',
                    ])
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
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('is_integral')
                    ->formatStateUsing(fn(?bool $state): string => $state ? __("Integral") : __("Ordinary"))
                    ->searchable()
                    ->label('Salary Mode')
                    ->colors(['primary']),
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
                // Filter::make('cluster_match')
                //     ->label('Company Name')
                //     ->query(fn(Builder $query): Builder => $query->where('cluster_name', self::getClusterName()))
                //     ->default(),
                // SelectFilter::make('contract_type')
                //     ->options([
                //         'customer' => 'Customer',
                //         'employee' => 'Employee',
                //     ])
                //     ->default('employee'),

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
                        $contractQuotationType = $record->is_integral;
                        $tr = new GoogleTranslate();
                        $tr->setSource();
                        $tr->setTarget('es');
                        $record->translatedMonth = $tr->translate(now()->format('F'));
                        switch (true) {
                            case $contractQuotationType === 0 && $record->end_date == null:
                                $pdfPage = 'pdf.contract.colombia.ordinary_undefined_employee';
                                break;
                            case $contractQuotationType === 0 && $record->end_date != null:
                                $pdfPage = 'pdf.contract.colombia.ordinary_defined_employee';
                                break;
                            case $contractQuotationType === 1 && $record->end_date == null:
                                $pdfPage = 'pdf.contract.colombia.integral_undefined_employee';
                                break;
                            case $contractQuotationType === 1 && $record->end_date != null:
                                $pdfPage = 'pdf.contract.colombia.integral_defined_employee';
                                break;
                            default:
                                break;
                        }
                        $year = date('Y', strtotime($record->created_at));
                        $formattedId = sprintf('%04d', $record->id);
                        $record->translatedPosition = $tr->translate($record->job_title ?? "");

                        $contractTitle = $year . '.' . $formattedId;
                        $startDateFormat = Carbon::parse($record->start_date)->format('d.m.y');
                        $fileName = $startDateFormat . '_Contrato Individual de ' . $record->employee->name . '_of employee';
                        $footerDetails = [
                            'companyName' => 'Intermediano Colombia S.A.S',
                            'address' => 'Calle Carrera 9 #115-30, Edificio Tierra Firme Oficina 1745 Bogotá, Bogotá DC, Colombia',
                            'domain' => 'www.intermediano.com',
                            'mobile' => '+1 514-907-5393'
                        ];
                        $pdf = Pdf::loadView($pdfPage, [
                            'record' => $record,
                            'poNumber' => $contractTitle,
                            'is_pdf' => true,
                            'footerDetails' => $footerDetails

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

    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()
    //         ->withoutGlobalScopes([
    //             SoftDeletingScope::class,
    //         ]);
    // }
    protected static function getClusterName(): string
    {
        return class_basename(self::$cluster);
    }
}
